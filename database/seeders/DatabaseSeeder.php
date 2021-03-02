<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;



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

        // DB::table('users')->insert([
        //     'name' => 'fdg df',
        //     'email' => 'test@test.c',
        //     'email_verified_at' => now(),
        //     'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        //     'remember_token' => Str::random(10),
        // ]);

        $defaultUser = \App\Models\User::factory(1)->defaultUser()->create();
        $otherUsers = \App\Models\User::factory(20)->create();

        // dd(get_class($else));

        $users = $otherUsers->concat($defaultUser);


        $posts = \App\Models\BlogPost::factory(30)->make()->each(function($post) use ($users) {
            $post->user_id = $users->random()->id;
            $post->save();

        });

        $comments = \App\Models\Comment::factory(150)->make()->each(function($comment) use ($posts) {
            $comment->blog_post_id = $posts->random()->id;
            $comment->save();

        });
    }
}
