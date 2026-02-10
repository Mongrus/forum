<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\enum\UserStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'avatar',
        'password',
        'status',
        'is_banned'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = ['is_online'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => UserStatus::class,
            'is_banned' => 'boolean',
        ];
    }

    public function getIsOnlineAttribute(): bool
    {
        return Cache::has("user:{$this->id}:online");
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'author_id');
    }

    public function friends()
    {
        return $this->belongsToMany(
            User::class,
            'friends',
            'user_id',
            'friend_id'
        );
    }

    public function messages()
    {
        return Message::query()
        ->where('sender_id', $this->id)
        ->orWhere('recipient_id', $this->id);
    }

    public function supportTickets()
    {
        return $this->hasMany(SupportTicket::class);
    }
}
