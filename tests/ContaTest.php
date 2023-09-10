<?php

namespace Tests;

class ContaTest extends TestCase
{
    public function test_criar_conta()
    {
        $dados = [
            'conta_id'  => 1234,
            'valor'     => 189.70,
        ];

        $response = $this->json('POST', '/conta', $dados);

        $response->seeStatusCode(201);

        $response->seeJson([
            'conta_id' => 1234
        ]);

        return 1234;
    }

    public function test_consultar_conta()
    {
        $conta_criada_id = $this->test_criar_conta();

        $response = $this->json('GET', '/conta?id=' . $conta_criada_id);

        $response->seeStatusCode(200);

        $response->seeJson([
            'conta_id' => 1234
        ]);

        $json = json_decode($response->response->getContent(), true);

        // Verifique se a chave "saldo" existe e se seu valor é um número
        $this->assertArrayHasKey('saldo', $json);
        $this->assertIsNumeric($json['saldo']);
    }
}