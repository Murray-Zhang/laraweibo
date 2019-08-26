<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(App\Models\User::class, 500)->create();

        $myuser = User::find(1);
        $myuser->name = 'zhz';
        $myuser->email = 'zhz@qq.com';
        $myuser->is_admin = true;
        $myuser->save();
    }
}
