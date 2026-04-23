<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@example.com')->first();
        $author1 = User::where('email', 'author@example.com')->first();
        $author2 = User::where('email', 'author2@example.com')->first();

        // Admin posts
        Post::create([
            'user_id' => $admin->id,
            'title' => 'Welcome to Our Blog',
            'content' => 'This is the first post created by the admin. Welcome to our blog where we share amazing content.',
        ]);

        Post::create([
            'user_id' => $admin->id,
            'title' => 'Community Guidelines',
            'content' => 'Please read our community guidelines before posting. Be respectful and kind to others.',
        ]);

        // Author 1 posts
        Post::create([
            'user_id' => $author1->id,
            'title' => 'Getting Started with Laravel',
            'content' => 'Laravel is a powerful PHP framework. In this post, we will explore the basics of Laravel.',
        ]);

        Post::create([
            'user_id' => $author1->id,
            'title' => 'Tailwind CSS Tips',
            'content' => 'Tailwind CSS makes styling easy. Here are some tips to get started with utility-first CSS.',
        ]);

        // Author 2 posts
        Post::create([
            'user_id' => $author2->id,
            'title' => 'Database Best Practices',
            'content' => 'Learn about database design, indexing, and optimization in this comprehensive guide.',
        ]);

        Post::create([
            'user_id' => $author2->id,
            'title' => 'API Development',
            'content' => 'Building RESTful APIs with Laravel is straightforward. Let me show you how.',
        ]);
    }
}
