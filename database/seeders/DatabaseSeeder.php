<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Comment;
use App\Models\Community;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

    /*    
           //Creación de 5 usuarios
           User::factory(5)
           //perfil
           ->hasProfile()
           ->create();
   
           Community::factory(3)
           ->hasUser()
           ->create();

           User::factory(5)
           //perfil
           ->hasPost(3)->create();*/


           $posts = Post::all();
           foreach ($posts as $post){
            $comment1= Comment::factory();
            $comment2= Comment::factory();
            $comment1->post_id=$comment1;
            $comment2->belongsTo($post)->save();

           }




        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
