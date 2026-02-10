<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\PostCreateRequest;
use App\Models\Post;
use App\Models\Section;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PostController extends Controller
{
    public function index(Section $section, $themeId)
    {
        $theme = $section->themes()->findOrFail($themeId);

        $posts = $theme
            ->posts()
            ->with('author')
            ->where('moderation', true)
            ->latest()
            ->paginate(5);

        return Inertia::render('Post/Posts', [
            'posts' => $posts,
            'sectionId' => $section->id,
            'themeId' => $themeId
        ]);
    }

    public function show($postId)
    {
        $post = Post::with([
            'author',
            'theme',
            'section',
            'comments.author'
            ])->findOrFail($postId);

        return Inertia::render('Post/Post', [
            'post' => $post
        ]);
    }

    public function create()
    {
        $sections = Section::with('themes')->get();

        return Inertia::render('Post/CreatePost', [
            'sections' => $sections
        ]);
    }

    public function store(PostCreateRequest $request)
    {
        $data = $request->validated();

        if (!empty($data['custom_theme'])) {
            $theme = Theme::create([
                'title' => $data['custom_theme'],
                'section_id' => $data['section_id']
            ]);

            $themeId = $theme->id;

            Post::create([
                'title' => $data['title'],
                'description' => $data['description'],
                'moderation' => false,
                'author_id' => Auth::user()->id,
                'section_id' => $data['section_id'],
                'theme_id' => $themeId
            ]);

            return redirect()->route('post.index', [$data['section_id'], $themeId])
            ->with('success', 'Ваш пост отправлен на модерацию и будет рассмотрен в течении 2 рабочих дней');
        } else {
            Post::create([
                'title' => $data['title'],
                'description' => $data['description'],
                'moderation' => false,
                'author_id' => Auth::user()->id,
                'section_id' => $data['section_id'],
                'theme_id' => $data['theme_id']
            ]);

            return redirect()->route('post.index', [$data['section_id'], $data['theme_id']])
            ->with('success', 'Ваш пост отправлен на модерацию и будет рассмотрен в течении 2 рабочих дней');
        }

    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'post_id' => 'required|integer',
            'title' => 'required|string|min:3|max:30',
            'description' => 'required|string|min:10|max:3000'
        ]);

        Post::where('id', $data['post_id'])
        ->update([
            'title' => $data['title'],
            'description' => $data['description']
        ]);

        return redirect()->back()->with('success', 'Пост успешно обновлен');
    }


    public function delete($postId)
    {
        Post::destroy($postId);

        $previous = url()->previous();

        if (str_contains($previous, '/posts/moderation')) {
            return redirect()
            ->back()
            ->with('success', 'Пост отклонен!');
        }

        return redirect()->route('section.index')->with('success', 'Пост успешно удален!');
    }

    public function moderation()
    {
        $posts = Post::where('moderation', false)
        ->with([
            'author',
            'theme',
            'section'])
        ->paginate(5);

        return Inertia::render('Post/ModerationPost', [
            'posts' => $posts
        ]);
    }

    public function confirm($postId)
    {
        Post::findOrFail($postId)
        ->update([
            'moderation' => true
        ]);

        return redirect()->back()->with('success', "Пост {$postId} успешно одобрен");
    }
}
