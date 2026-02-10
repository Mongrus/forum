<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'moderation',
        'author_id',
        'section_id',
        'theme_id',
    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
