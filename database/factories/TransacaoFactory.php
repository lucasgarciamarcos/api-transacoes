<?php

namespace Database\Factories;

use App\Models\Conta;
use App\Models\Transacao;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransacaoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transacao::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Obtém um ID de conta existente na tabela 'contas'
        $contaId = Conta::inRandomOrder()->first()->id;

        return [
            'conta_id' => $contaId,
            'valor' => $this->faker->randomFloat(2, 1, 10000),
            'forma_pagamento' => $this->faker->randomElement(Transacao::getFormasPagamento()),
        ];
    }
}
