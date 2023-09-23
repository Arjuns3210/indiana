<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'admin_name' => 'maaz',
            'email' => 'maaz@mail.com',
            'country_id' => 1,
            'phone' => rand(1111111111, 9999999999),
            'password' => md5('maaz@mail.com123456'),
            'address' => 'Address',
            'role_id' => 1,
        ]);
    }
}
