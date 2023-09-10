<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transacao;
use App\Services\TransacaoService;

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

        $response = TransacaoService::create($request->toArray());

        return $response;
    }
}