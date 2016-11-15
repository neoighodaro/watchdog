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
        $users = [
            [
                'name'       => 'Product',
                'email'      => 'product@hotels.ng',
                'password'   => bcrypt(env('ADMIN_USER_PASSWORD')),
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now(),
            ]
        ];

        DB::table('users')->insert($users);
    }
}
