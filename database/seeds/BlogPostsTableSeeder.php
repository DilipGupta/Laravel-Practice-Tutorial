<?php

use Illuminate\Database\Seeder;

class BlogPostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Start =this line of code ask user for how much blog post you want to create
        $blogCount=(int)$this->command->ask('How many blog posts would you like?',40);
        //End

        $user=App\user::all();

        factory(App\BlogPost::class,$blogCount)->make()->each(function($post) use ($user){
            $post->user_id=$user->random()->id;
            $post->save();
        });
    }
}
