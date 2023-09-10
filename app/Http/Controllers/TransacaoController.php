<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transacao;
use App\Models\Conta;

class TransacaoController extends Controller
{
    /**
     * Cria uma nova transação.
     *
     * @param Request $request Os dados da requisição.
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $this->validate($request, Transacao::getRules());

        $transacao = new Transacao($request->toArray());

        $conta = Conta::where('conta_id', $request->conta_id)->first();

        if (!$conta) {
            return response()->json(['error' => 'Conta não encontrada'], 404);
        }

        $conta->saldo = $conta->saldo - Transacao::aplicarTaxa($transacao->forma_pagamento, $transacao->valor);

        if ($conta->saldo < 0) {
            return response()->json(['error' => 'Conta não possui saldo suficiente para a operacao'], 404);
        }

        if ($conta->save()) {
            $transacao->save();
        }

        return response()->json([
            'conta_id'  => $conta->conta_id,
            'saldo'     => number_format($conta->saldo, 2)
        ], 201);
    }
}