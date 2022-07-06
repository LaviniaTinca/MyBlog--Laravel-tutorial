<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::truncate();
        Post::truncate();
        Category::truncate();

        //Post::factory()->create(); // we will have a generic post with a generic category written by a generic author
        $user = User::factory()->create([
            'name' => 'John Doe'
        ]);
        Post::factory(5)->create([
            'user_id' => $user->id
        ]);
        // $personal = Category::create([
        //     'name' => 'Personal',
        //     'slug' => 'personal'
        // ]);
        // $work = Category::create([
        //     'name' => 'Work',
        //     'slug' => 'work'
        // ]);
        // $family = Category::create([
        //     'name' => 'Hobbies',
        //     'slug' => 'hobbies'

        // ]);

        // Post::create([
        //     'user_id'=>$user->id,
        //     'category_id'=>$family->id,
        //     'title'=>'My Family Post',
        //     'slug'=>'my-first-post',
        //     'excerpt'=> 'excerpt for my post',
        //     'body'=> 'Lorem ipsum dolor si amet.'
        // ]);
        // Post::create([
        //     'user_id'=>$user->id,
        //     'category_id'=>$work->id,
        //     'title'=>'My Work Post',
        //     'slug'=>'my-second-post',
        //     'excerpt'=> 'excerpt for my post',
        //     'body'=> 'Lorem ipsum dolor si amet.'
        // ]);
        // Post::create([
        //     'user_id'=>$user->id,
        //     'category_id'=>$personal->id,
        //     'title'=>'My Personal Post',
        //     'slug'=>'my-third-post',
        //     'excerpt'=> 'excerpt for my post',
        //     'body'=> 'Lorem ipsum dolor si amet.'
        // ]);
    }
}
