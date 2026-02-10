<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Section;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        Section::factory()
            ->count(rand(3, 5))
            ->create()
            ->each(function ($section) {

                Theme::factory()
                    ->count(rand(4, 7))
                    ->for($section)
                    ->create()
                    ->each(function ($theme) use ($section) {

                        Post::factory()
                            ->count(rand(3, 5))
                            ->create([
                                'section_id' => $section->id,
                                'theme_id'   => $theme->id,
                                'author_id'  => User::inRandomOrder()->value('id'),
                            ])
                            ->each(function ($post) {

                                Comment::factory()
                                    ->count(rand(1, 2))
                                    ->create([
                                        'post_id'   => $post->id,
                                        'author_id' => User::inRandomOrder()->value('id'),
                                    ]);

                            });
                    });
            });
    }
}
