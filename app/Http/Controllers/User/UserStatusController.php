<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class UserStatusController extends Controller
{
    public function online()
    {
        Cache::put(
            "user:" . auth()->id() . ":online",
            true,
            now()->addSeconds(60)
        );

        return response()->noContent();
    }

    public function offline()
    {
        Cache::forget("user:" . auth()->id() . ":online");

        return response()->noContent();
    }
}
