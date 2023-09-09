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
}
