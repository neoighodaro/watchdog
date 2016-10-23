<?php

use Illuminate\Database\Seeder;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = [
            [
                'name' => 'Hotels.ng',
                'url' => 'https://hotels.ng',
                'description' => 'Hotels.ng Official Website.',
                'type' => 'http',
                'user_id' => 1,
                'deleted_at' => NULL,
                'meta' => '{}',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ],
            [
                'name' => 'Finance Place',
                'url' => 'http://finance.place',
                'description' => 'Finance Place.',
                'type' => 'http',
                'user_id' => 1,
                'deleted_at' => NULL,
                'meta' => '{}',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ],
        ];

        DB::table('services')->insert($services);
    }
}
