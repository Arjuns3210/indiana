<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('currencies')->insert([
            'currency_name' => 'Rupees',
            'currency_symbol' => '₹',
            'currency_code' => 'INR',
            'exchange_rate' => '74.000',
        ]);
    }
}
