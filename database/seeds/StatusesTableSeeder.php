<?php

use Illuminate\Database\Seeder;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_ids = [1,2,3,4,5];

        $faker = app(Faker\Generator::class);

        $statuses = factory(App\Models\Status::class, 500)->make()->each(function ($status) use ($user_ids, $faker){
            $status->user_id = $faker->randomElement($user_ids);


        });

        \App\Models\Status::insert($statuses->toArray());
    }
}
