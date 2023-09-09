<?php

namespace Database\Seeders;

use App\Models\Transacao;
use Illuminate\Database\Seeder;

class TransacoesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Transacao::factory()->create();
    }
}
