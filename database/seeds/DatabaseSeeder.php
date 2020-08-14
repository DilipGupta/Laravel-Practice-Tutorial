<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      //Start =this line's of code ask user for fresh and migrate table
      if($this->command->confirm('Do you want to refresh the database?')){
        $this->command->call('migrate:fresh');
        $this->command->info('Database was refreshed');
      }
      //End

      $this->call([UsersTableSeeder::class, BlogPostsTableSeeder::class, CommentsTableSeeder::class]);
    }
}
