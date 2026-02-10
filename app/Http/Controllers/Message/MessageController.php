<?php

namespace App\Http\Controllers\Message;

use App\Events\MessageSent;
use App\Events\UserNotTyping;
use App\Events\UserTyping;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class MessageController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $chatUserIds = Message::where('sender_id', $userId)
            ->orWhere('recipient_id', $userId)
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($message) use ($userId) {
                return $message->sender_id === $userId
                    ? $message->recipient_id
                    : $message->sender_id;
            })
            ->unique()
            ->values();

        $users = User::whereIn('id', $chatUserIds)
        ->get()
        ->sortBy(fn ($u) => $chatUserIds->search($u->id))
        ->values();

        return Inertia::render('Message/Messages', [
            'chats' => $users
        ]);
    }

    public function chat($userId)
    {
        abort_if(auth()->user()->id === (int)$userId, 404);

        $me = auth()->id();

        $messages = Message::where(function ($q) use ($me, $userId) {
            $q->where('sender_id', $me)
              ->where('recipient_id', $userId);
        })
            ->orWhere(function ($q) use ($me, $userId) {
                $q->where('sender_id', $userId)
                  ->where('recipient_id', $me);
            })
            ->orderBy('created_at')
            ->get();

        $recipient = User::findOrFail($userId);


        return Inertia::render('Message/Chat', [
            'messages' => $messages,
            'recipient' => $recipient,
            'is_online' => Cache::has("user:{$recipient->id}:online"),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'message' => 'required|string|min:1|max:300',
            'recipient_id' => 'required|integer'
        ]);

        $message = Message::create([
            'message' => $data['message'],
            'sender_id' => auth()->user()->id,
            'recipient_id' => $data['recipient_id']
        ]);

        $chatId = min(auth()->id(), $request->recipient_id) . '_' . max(auth()->id(), $request->recipient_id);

        event(new MessageSent($message, $chatId));
        event(new UserTyping(auth()->id(), $chatId));

        return redirect()->back();
    }

    public function delete($chatId)
    {
        $userId = auth()->id();

        Message::where(function ($q) use ($userId, $chatId) {
            $q->where('sender_id', $userId)
              ->where('recipient_id', $chatId);
        })
        ->orWhere(function ($q) use ($userId, $chatId) {
            $q->where('sender_id', $chatId)
              ->where('recipient_id', $userId);
        })
        ->delete();

        return redirect()
            ->route('messages')
            ->with('success', 'Чат с пользователем удален');
    }

    public function typing(Request $request)
    {
        $chatId = min(auth()->id(), $request->recipient_id)
        . '_' .
        max(auth()->id(), $request->recipient_id);

        event(new UserTyping(
            auth()->id(),
            $chatId
        ));

        return response()->noContent();
    }

    public function notTyping(Request $request)
    {
        $chatId = min(auth()->id(), $request->recipient_id)
        . '_' .
        max(auth()->id(), $request->recipient_id);

        event(new UserNotTyping(
            auth()->id(),
            $chatId
        ));

        return response()->noContent();

    }

}
