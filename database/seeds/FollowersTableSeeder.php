<?php

use Illuminate\Database\Seeder;

class FollowersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $users = \App\Models\User::all();
        $firstuser = $users->first();
        $firstuser_id = $firstuser->id;

        //获取除了第一条意外所有的id数组
        $followers = $users->slice(1);

        $followers_ids = $followers->pluck('id')->toArray();

        //第一条关注所有人
        $firstuser->follow($followers_ids);
        //所有人都关注第一条
        foreach ($followers as  $follower){
            $follower->follow($firstuser_id);
        }
    }
}
