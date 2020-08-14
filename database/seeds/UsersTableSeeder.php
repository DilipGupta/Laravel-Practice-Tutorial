<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Start =this line of code ask user for how much user you want to create
        $userCount=(int)$this->command->ask('How many users would you like?',20);
        //End
        
        factory(App\User::class)->state('dilip-gupta')->create();
        factory(App\User::class,$userCount)->create();
    }
}
