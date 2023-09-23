<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            'name' => 'Status',
            'codename' => 'staff_delete',
            'parent_status' => 1,
            'description' => 'Status',
            'status' => 'Yes',
        ]);
    }
}
