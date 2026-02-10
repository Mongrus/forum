<?php

use App\Http\Controllers\Comment\CommentController;
use App\Http\Controllers\Friend\FriendController;
use App\Http\Controllers\Message\MessageController;
use App\Http\Controllers\Post\PostController;
use App\Http\Controllers\Section\SectionController;
use App\Http\Controllers\SupportTicket\SupportTicketController;
use App\Http\Controllers\Theme\ThemeController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\UserStatusController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Главная
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// Маршруты, только для авторизованных пользователей
Route::middleware('auth')->group(function () {
    Route::middleware('not_banned')->group(function () {
        // Онлайн/оффлайн
        Route::post('/user/online', [UserStatusController::class, 'online'])->name('user.online');
        Route::post('/user/offline', [UserStatusController::class, 'offline'])->name('user.offline');

        // Профиль пользователя
        Route::get('/profile/{profileId}', [UserController::class, 'profile'])->name('profile');
        Route::put('/profile/update_avatar/{avatarId}', [UserController::class, 'updateAvatar'])->name('avatar.update');

        // Все пользователи
        Route::get('/users', [UserController::class, 'index'])->name('users');

        // Сообщения
        Route::get('/messages', [MessageController::class, 'index'])->name('messages');
        Route::get('/chat/{userId}', [MessageController::class, 'chat'])->name('chat');
        Route::post('/message/create', [MessageController::class, 'store'])->middleware('throttle:chat')->name('message.store');
        Route::delete('/message/delete/{chatId}', [MessageController::class, 'delete'])->name('message.delete');

        // Пользователь (не)печатает
        Route::post('/message/typing', [MessageController::class, 'typing'])->name('message.typing');
        Route::post('/message/not_typing', [MessageController::class, 'notTyping'])->name('message.notTyping');

        // Комментарии
        Route::post('/post/{postId}/comment/create', [CommentController::class, 'store'])->middleware('throttle:10,1')->name('comment.store');
        Route::delete('/comment/delete/{commentId}', [CommentController::class, 'delete'])->name('comment.delete');

        // Друзья пользователя
        Route::get('/friends', [FriendController::class, 'index'])->name('friends');
        Route::post('/friends/{friendId}', [FriendController::class, 'store'])->name('friend.store');
        Route::delete('/friends/delete/{friendId}', [FriendController::class, 'delete'])->name('friend.delete');

        // Операции с постами
        Route::get('/post/create', [PostController::class, 'create'])->name('post.create');
        Route::post('/post/store', [PostController::class, 'store'])->middleware('throttle:5,1')->name('post.store');
        Route::patch('/post/update', [PostController::class, 'update'])->name('post.update');
        Route::delete('/post/delete/{postId}', [PostController::class, 'delete'])->name('post.delete');



        // Только для администрации сайта
        Route::middleware('moderator_or_admin')->group(function () {
            // Бан/Разбан
            Route::patch('/user/{user}/banned', [UserController::class, 'banned'])->name('user.banned');

            // Модерация постов
            Route::get('/posts/moderation', [PostController::class, 'moderation'])->name('posts.moderation');
            Route::patch('/post/confirm/{postId}', [PostController::class, 'confirm'])->name('post.confirm');

            // Создать раздел
            Route::get('/section/create', [SectionController::class, 'create'])->name('section.create');
            Route::post('/section/store', [SectionController::class, 'store'])->name('section.store');

            // Создать тему
            Route::get('/theme/create', [ThemeController::class, 'create'])->name('theme.create');
            Route::post('/theme/store', [ThemeController::class, 'store'])->name('theme.store');

            // Обращения в поддержку
            Route::get('/support/moderation', [SupportTicketController::class, 'moderation'])->name('support.moderation');
            Route::patch('/support/completed/{ticketId}', [SupportTicketController::class, 'supportResponse'])->name('support.completed');

        });
    });

    // Пользователь может обратиться в поддержку если, что б пересмотрели причину его бана
    Route::get('/support', [SupportTicketController::class, 'index'])->name('support.index');
    Route::post('/support/create', [SupportTicketController::class, 'store'])->name('support.store');
});

Route::middleware('not_banned')->group(function () {
    // Секции->Темы->Посты
    Route::get('/sections', [SectionController::class, 'index'])->name('section.index');
    Route::get('/sections/{id}', [ThemeController::class, 'index'])->name('theme.index');
    Route::get('/sections/{section}/theme/{themeId}', [PostController::class, 'index'])->name('post.index');
    Route::get('/post/{postId}', [PostController::class, 'show'])->name('post.show');
});


require __DIR__.'/auth.php';
