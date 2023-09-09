<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conta;

class ContaController extends Controller
{
    public function list(Request $request)
    {
        $this->validate($request, [
            'search' => 'nullable'
        ]);

        $contas = Conta::all();
        return response()->json($contas);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'conta_id' => 'required',
            'valor' => 'required|numeric',
        ]);

        $conta = Conta::where('conta_id', $request->conta_id)->first();

        if ($conta) {
            // Prepara o objeto conta para a entrega
            $conta = New Conta($conta->toArray());
            
            return response()->json([
                'conta_id' => $conta->conta_id,
                'saldo' => $conta->saldo
            ], 201);
        }

        $conta = new Conta([
            'conta_id' => $request->conta_id,
            'saldo' => $request->valor
        ]);

        $conta = Conta::criar($conta);

        return response()->json([
            'conta_id' => $conta->conta_id,
            'saldo' => $conta->saldo
        ], 201);
    }

    public function get(Request $request)
    {
        $conta_id = $request->query('id');

        if(!ctype_digit($conta_id)) {
            return response()->json(['error' => 'Parâmetro "id" é do tipo integer e obrigatório.'], 400);
        }

        $conta = Conta::where('conta_id', $conta_id)->first();

        if (!$conta) {
            return response()->json(['error' => 'Conta não encontrada'], 404);
        }

        $conta = new Conta($conta->toArray());

        return response()->json([
            'conta_id' => $conta->conta_id,
            'saldo' => $conta->saldo
        ], 200);
    }

    public function quinhentos()
    {
        // Em um banco como mySQL daria pra fazer desta forma mas vou utilizar uma forma mais simples por se tratar de sqlite
        // $menorContaIdNaoExistente = Conta::selectRaw('MIN(t1.conta_id + 1) AS menor_conta_id')
        //    ->from('contas AS t1')
        //    ->leftJoin('contas AS t2', 't1.conta_id + 1', '=', 't2.conta_id')
        //    ->whereNull('t2.conta_id')
        //    ->first();

        // $menorContaId = $menorContaIdNaoExistente->menor_conta_id ?? 1; // Se não encontrar nenhum valor, assume 1 como o menor valor possível

        $menorContaIdExistente = Conta::min('conta_id');
        $menorContaId = $menorContaIdExistente + 1;

        while (Conta::where('conta_id', $menorContaId)->exists()) {
            $menorContaId++;
        }

        $conta = new Conta([
            'conta_id' => $menorContaId,
            'saldo' => 500.00
        ]);

        $conta = Conta::criar($conta);

        return response()->json([
            'conta_id' => $conta->conta_id,
            'saldo' => $conta->saldo
        ], 201);
    }
}
