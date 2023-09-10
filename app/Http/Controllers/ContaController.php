<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conta;

class ContaController extends Controller
{
    /**
     * Lista todas as contas ou filtra por pesquisa (opcional).
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request)
    {
        $this->validate($request, [
            'search' => 'nullable'
        ]);

        $contas = Conta::all();
        return response()->json($contas);
    }

    /**
     * Cria uma nova conta ou atualiza o saldo de uma conta existente.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'conta_id'  => 'numeric|min:0',
            'valor'     => 'numeric|min:0',
        ]);

        $conta = Conta::where('conta_id', $request->conta_id)->first();

        if ($conta) {
            // Prepara o objeto conta para a entrega
            $conta = new Conta($conta->toArray());

            return response()->json([
                'conta_id'  => $conta->conta_id,
                'saldo'     => $conta->saldo
            ], 201);
        }

        $conta = new Conta([
            'conta_id'  => $request->conta_id,
            'saldo'     => $request->valor
        ]);

        $conta = Conta::criar($conta);

        return response()->json([
            'conta_id'  => $conta->conta_id,
            'saldo'     => $conta->saldo
        ], 201);
    }

    /**
     * Obtém informações de uma conta pelo ID.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Request $request)
    {
        $conta_id = $request->query('id');

        if (!ctype_digit($conta_id)) {
            return response()->json(['error' => 'Parâmetro "id" é do tipo integer e obrigatório.'], 400);
        }

        $conta = Conta::where('conta_id', $conta_id)->first();

        if (!$conta) {
            return response()->json(['error' => 'Conta não encontrada'], 404);
        }

        $conta = new Conta($conta->toArray());

        return response()->json([
            'conta_id'  => $conta->conta_id,
            'saldo'     => $conta->saldo
        ], 200);
    }

    /**
     * Cria uma nova conta com um saldo inicial de 500.00.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function quinhentos()
    {
        // Em um banco como mySQL daria pra fazer desta forma mas vou utilizar uma forma mais simples por se tratar de sqlite
        // $menorContaIdNaoExistente = Conta::selectRaw('MIN(t1.conta_id + 1) AS menor_conta_id')
        //    ->from('contas AS t1')
        //    ->leftJoin('contas AS t2', 't1.conta_id + 1', '=', 't2.conta_id')
        //    ->whereNull('t2.conta_id')
        //    ->first();

        // $menorContaId = $menorContaIdNaoExistente->menor_conta_id ?? 1; // Se não encontrar nenhum valor, assume 1 como o menor valor possível

        $nextContaId = Conta::max('conta_id') + 1;

        $conta = new Conta([
            'conta_id'  => $nextContaId,
            'saldo'     => 500.00
        ]);

        $conta = Conta::criar($conta);

        return response()->json([
            'conta_id'  => $conta->conta_id,
            'saldo'     => $conta->saldo
        ], 201);
    }
}
