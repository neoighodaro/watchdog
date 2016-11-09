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
                'name' => 'Hotels.ng (v5)',
                'url' => 'https://hotels.ng',
                'description' => 'Hotels.ng Official Website.',
                'type' => 'http',
                'user_id' => 1,
                'deleted_at' => NULL,
                'meta' => '{}',
                'cron' => '* * * * * *',
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
                'cron' => '* * * * * *',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ],
            [
                'name' => 'HMS',
                'url' => 'https://hms.hotels.ng',
                'description' => 'Hotel Management System.',
                'type' => 'http',
                'user_id' => 1,
                'deleted_at' => NULL,
                'meta' => '{}',
                'cron' => '* * * * * *',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ],
        ];

        DB::table('services')->insert($services);
    }
}
