<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'botmin';
        $user->password = Hash::make('theyplayeduslikeadamnfiddle');
        $user->email = 'hello@winfred.work';
        $user->save();
    }
}
