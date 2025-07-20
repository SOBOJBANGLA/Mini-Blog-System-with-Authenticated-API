<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first(); // demo user
        $categories = Category::all();

        foreach ($categories as $category) {
            Article::create([
                'title' => "Sample Article in {$category->name}",
                'slug' => Str::slug("Sample Article in {$category->name}"),
                'body' => "This is a sample article about {$category->name}.",
                'status' => 'published',
                'category_id' => $category->id,
                'user_id' => $user->id,
            ]);
        }
    }
}
