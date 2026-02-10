<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /*
    Используем этот метод, если необходимо что-то пробросить из Laravel во
    Vue через Inertia, а там достать при помощи usePage
    */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            // Изначальный блок для прокидывания информации по авторизации во Vue
            'auth' => function () use ($request) {
                $user = $request->user();

                return [
                    'user' => $user,
                    'friends_ids' => $user
                        ? $user->friends()->pluck('users.id')
                        : [],
                ];
            },

            // Дополнительный блок для flash иначе будут пустые flash во Vue
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error'   => fn () => $request->session()->get('error')
            ],
        ];
    }
}
