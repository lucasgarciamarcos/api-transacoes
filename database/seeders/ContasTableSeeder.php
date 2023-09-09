<?php

namespace Database\Seeders;

use App\Models\Conta;
use Illuminate\Database\Seeder;

class ContasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Conta::factory()->create();
    }
}
