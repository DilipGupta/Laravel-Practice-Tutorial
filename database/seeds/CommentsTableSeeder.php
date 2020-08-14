<?php

use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $posts=App\BlogPost::all();
        
        if($posts->count() === 0){
            $this->command->info('There are no blog post, so no comments will be added');
            return;
        }
        $commentCount=(int)$this->command->ask('How many comments would you like?',60);
        factory(App\Comment::class, $commentCount)->make()->each(function($comment) use ($posts){
            $comment->blog_post_id=$posts->random()->id;
            $comment->save();
        });
    }
}
