<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, $postId)
    {
        $data = $request->validate([
            'comment' => 'required|string|min:1|max:300',
        ]);

        Comment::create([
            'comment' => $data['comment'],
            'author_id' => auth()->user()->id,
            'post_id' => $postId
        ]);

        return redirect()->back()->with('success', 'Комментарий успешно опубликован');
    }

    public function delete($commentId)
    {
        Comment::destroy($commentId);

        return redirect()->back()->with('success', 'Комментарий успешно удален!');
    }
}
