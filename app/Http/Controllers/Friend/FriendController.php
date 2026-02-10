<?php

namespace App\Http\Controllers\Friend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class FriendController extends Controller
{
    public function index()
    {
        $friends = auth()->user()->friends()->get();

        return Inertia::render('Friend/Friends', [
            'friends' => $friends
        ]);
    }

    public function store($friendId)
    {
        auth()->user()->friends()->attach($friendId);

        return Redirect::back()->with('friends')->with('success', 'Пользователь успешно добавлен в ваш список друзей');
    }

    public function delete($friendId)
    {
        auth()->user()->friends()->detach($friendId);

        return Redirect::back()->with('success', 'Пользователь удален из вашего списка друзей');
    }
}
