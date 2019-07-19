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
        factory(App\User::class,20)->create();
        $users = App\User::all();
        foreach ($users as $user) {
            $user->createToken("Auth Token")->accessToken;
        }
    }
}
