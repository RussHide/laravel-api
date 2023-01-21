<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;


class DatabaseSeeder extends Seeder
{

    public function run()
    {

        Storage::deleteDirectory('posts');
        Storage::makeDirectory('posts');


        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(UserSeeder::class);
        Category::factory(4)->create();
        Tag::factory(8)->create();
        $this->call(PostSeeder::class);
    }
}
