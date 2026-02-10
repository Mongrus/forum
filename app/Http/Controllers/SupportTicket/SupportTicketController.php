<?php

namespace App\Http\Controllers\SupportTicket;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SupportTicketController extends Controller
{
    public function index()
    {
        $tickets = SupportTicket::where('user_id', auth()->id())
        ->latest()
        ->get();

        return Inertia::render('Support/UserTickets', [
            'tickets' => $tickets
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|min:5|max:50',
            'message' => 'required|string|min:20|max:500'
        ]);

        SupportTicket::create([
            'title' => $data['title'],
            'message' => $data['message'],
            'user_id' => auth()->id(),
            'completed' => false,
            'answer' => null
        ]);

        return redirect()->back()->with('success', 'Обращение успешно отправлено службе поддержки');
    }

    public function supportResponse(Request $request, $ticketId)
    {
        $data = $request->validate([
            'answer' => 'required|string|min:5|max:500'
        ]);

        SupportTicket::where('id', $ticketId)
        ->update([
            'answer' => $data['answer'],
            'completed' => true
        ]);

        return redirect()->back()->with('success', 'Обращение успешно обработано');
    }

    public function moderation()
    {
        $tickets = SupportTicket::where('completed', false)
        ->with('user')
        ->paginate(5);

        return Inertia::render('Support/ModerationTickets', [
            'tickets' => $tickets
        ]);
    }
}
