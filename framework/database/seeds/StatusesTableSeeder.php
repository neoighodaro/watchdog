<?php

use App\Service;
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
        $statuses = [];

        for ($i=0; $i < 10; $i++) {
            $statuses[] = [
                'service_id' => Service::whereUrl('https://hotels.ng')->first()->id,
                'response'   => $i == 7 ? 0 : 200,
                'created_at' => (new Carbon\Carbon)->addMinutes($i),
                'updated_at' => (new Carbon\Carbon)->addMinutes($i),
            ];
        }

        for ($i=0; $i < 10; $i++) {
            $statuses[] = [
                'service_id' => Service::whereUrl('https://hms.hotels.ng')->first()->id,
                'response'   => $i >= 5 ? 0 : 200,
                'created_at' => (new Carbon\Carbon)->addMinutes($i),
                'updated_at' => (new Carbon\Carbon)->addMinutes($i),
            ];
        }

        DB::table('statuses')->insert($statuses);
    }
}
