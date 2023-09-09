<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class Transacao extends Model
{
    use HasFactory;

    // Dicionário para formas de pagamento
    const FORMA_PAGAMENTO_DEBITO = 'D';
    const FORMA_PAGAMENTO_CREDITO = 'C';
    const FORMA_PAGAMENTO_PIX = 'P';

    protected $table = 'transacoes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'conta_id', 'valor', 'forma_pagamento'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $validator = Validator::make($attributes, self::getRules());

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    public static function getRules()
    {
        return [
            'conta_id'          => 'required',
            'valor'             => 'required|numeric',
            'forma_pagamento'   => 'required|in:' . implode(',', self::formasPagamento()),
        ];
    }

    /**
     * Retorna uma lista de formas de pagamento suportadas.
     *
     * @return array Uma lista das formas de pagamento suportadas.
     */
    public static function formasPagamento()
    {
        return [self::FORMA_PAGAMENTO_CREDITO, self::FORMA_PAGAMENTO_DEBITO, self::FORMA_PAGAMENTO_PIX];
    }

    /**
     * Aplica uma taxa ao valor com base na forma de pagamento.
     *
     * @param string $formaPagamento A forma de pagamento (use constantes para representar as formas de pagamento).
     * @param float $valor O valor ao qual a taxa deve ser aplicada.
     * @return float O valor com a taxa aplicada.
     */
    public static function aplicarTaxa(string $formaPagamento, float $valor)
    {
        // Dicionário de Taxas
        $taxas = [
            self::FORMA_PAGAMENTO_DEBITO => 0.03,
            self::FORMA_PAGAMENTO_CREDITO => 0.05,
        ];

        // Verifique se a forma de pagamento existe no dicionário de taxas
        if (array_key_exists($formaPagamento, $taxas)) {
            // Aplique a taxa ao valor
            $taxa = $taxas[$formaPagamento];
            $valorComTaxa = $valor + ($valor * $taxa);
            return $valorComTaxa;
        }

        // Se a forma de pagamento não estiver no dicionário, retorne o valor original
        return $valor;
    }
}
