<?php

namespace App\Http\Controllers\Theme;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\Theme;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ThemeController extends Controller
{
    public function index($id)
    {
        $themes = Theme::where('section_id', $id)
        ->with('posts')
        // Добавляет виртуальное поле содержащее дату самого нового поста в теме
        ->withMax('posts', 'created_at')
        // Сортирует по нему
        ->orderByDesc('posts_max_created_at')
        ->paginate(5);

        return Inertia::render('Theme/Theme', [
            'themes' => $themes
        ]);
    }

    public function create()
    {
        $sections = Section::get();

        return Inertia::render('Theme/CreateTheme', [
            'sections' => $sections
        ]);
    }

    public function store(Request $request)
    {

        $data = $request->validate([
            'section_id' => 'required|integer|exists:sections,id',
            'title' => 'required|string|min:3|max:80',
        ]);

        Theme::create([
            'title' => $data['title'],
            'section_id' => $data['section_id']
        ]);

        return redirect()->route('theme.index', $data['section_id'])
        ->with('success', 'Тема успешно создана');
    }
}
