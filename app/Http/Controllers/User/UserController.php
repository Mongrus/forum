<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('posts')
        ->paginate(5);

        return Inertia::render('User/Users', [
            'users' => $users,
        ]);
    }

    public function profile($id)
    {
        $user = User::findOrFail($id);

        $posts = Post::where('author_id', $id)
        ->latest()
        ->paginate(3);

        $myFriendsIds = auth()->user()
            ->friends()
            ->pluck('users.id')
            ->values();

        return Inertia::render('User/Profile', [
            'user' => $user,
            'posts' => $posts,
            'my_friends' => $myFriendsIds
        ]);
    }

    public function updateAvatar($avatarId)
    {
        Auth()->user()->update([
        'avatar' => "avatars/$avatarId.png"
        ]);

        return redirect()->back()->with('success', 'Аватар успешно изменен');
    }

    public function banned(User $user)
    {
        $user->is_banned = !$user->is_banned;
        $user->save();

        return redirect()->back()->with('success', "Операция с пользователем {$user->name} прошла успешно");
    }
}
