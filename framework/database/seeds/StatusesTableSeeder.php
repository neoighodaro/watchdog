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
        $statuses = [];

        for ($i=0; $i < 10; $i++) {
            $statuses[] = [
                'service_id' => 1,
                'response'   => $i == 8 ? 0 : 200,
                'created_at' => (new Carbon\Carbon)->addMinutes($i),
                'updated_at' => (new Carbon\Carbon)->addMinutes($i),
            ];
        }

        DB::table('statuses')->insert($statuses);
    }
}
