<?php
namespace App\Services;

use App\Models\Conta;
use App\Models\Transacao;
use Illuminate\Http\JsonResponse;

class TransacaoService
{
    public static function create(array $requestAttributes): JsonResponse
    {
        $transacao = new Transacao($requestAttributes);

        $conta = Conta::where('conta_id', $requestAttributes['conta_id'])->first();

        if (!$conta) {
            return response()->json(['error' => 'Conta não encontrada'], 404);
        }

        $conta->saldo = $conta->saldo - Transacao::aplicarTaxa($transacao->forma_pagamento, $transacao->valor);

        if ($conta->saldo < 0) {
            return response()->json(['error' => 'Conta não possui saldo suficiente para a operação'], 404);
        }

        if ($conta->save()) {
            $transacao->save();
            return response()->json([
                'conta_id' => $conta->conta_id,
                'saldo' => $conta->saldo
            ], 201);
        }

        return response()->json(['error' => 'Erro ao salvar a transação'], 500);
    }
}