<?php

namespace Tests;

class TransacaoTest extends TestCase
{
    public function criar_conta()
    {
        $response = $this->json('POST', '/quinhentos');

        $response->seeStatusCode(201);

        return json_decode($response->response->getContent(), true);
    }
    
    public function test_transacao_credito()
    {
        $conta_criada = $this->criar_conta();

        $dados = [
            'forma_pagamento' => "C", 
            'conta_id' => $conta_criada['conta_id'], 
            'valor' => 10
        ];

        $response = $this->json('POST', '/transacao', $dados);
        
        $saldo_esperado = $conta_criada['saldo'] - 10.5;
        
        $response->seeStatusCode(201);

        $response->seeJson([
            'conta_id' => $conta_criada['conta_id']
        ]);

        $json = json_decode($response->response->getContent(), true);

        // Verifique se a chave "saldo" existe e se seu valor é um número
        $this->assertArrayHasKey('saldo', $json);
        $this->assertIsNumeric($json['saldo']);
        $this->assertEquals($saldo_esperado, $json['saldo']);
    }

    public function test_transacao_debito()
    {
        $conta_criada = $this->criar_conta();

        $dados = [
            'forma_pagamento' => "D", 
            'conta_id' => $conta_criada['conta_id'], 
            'valor' => 10
        ];

        $response = $this->json('POST', '/transacao', $dados);

        $saldo_esperado = $conta_criada['saldo'] - 10.3;

        $response->seeStatusCode(201);

        $response->seeJson([
            'conta_id' => $conta_criada['conta_id']
        ]);

        $json = json_decode($response->response->getContent(), true);

        // Verifique se a chave "saldo" existe e se seu valor é um número
        $this->assertArrayHasKey('saldo', $json);
        $this->assertIsNumeric($json['saldo']);
        $this->assertEquals($saldo_esperado, $json['saldo']);
    }

    public function test_transacao_pix()
    {
        $conta_criada = $this->criar_conta();

        $dados = [
            'forma_pagamento' => "P", 
            'conta_id' => $conta_criada['conta_id'], 
            'valor' => 10
        ];

        $response = $this->json('POST', '/transacao', $dados);
        
        $saldo_esperado = $conta_criada['saldo'] - 10;

        $response->seeStatusCode(201);

        $response->seeJson([
            'conta_id' => $conta_criada['conta_id']
        ]);

        $json = json_decode($response->response->getContent(), true);

        // Verifique se a chave "saldo" existe e se seu valor é um número
        $this->assertArrayHasKey('saldo', $json);
        $this->assertIsNumeric($json['saldo']);
        $this->assertEquals($saldo_esperado, $json['saldo']);
    }

    public function test_transacao_sem_saldo()
    {
        $conta_criada = $this->criar_conta();

        $dados = [
            'forma_pagamento' => "P", 
            'conta_id' => $conta_criada['conta_id'], 
            'valor' => 20000
        ];

        $response = $this->json('POST', '/transacao', $dados);
        
        $response->seeStatusCode(404);

        $json = json_decode($response->response->getContent(), true);

        // Verifique se a chave "saldo" existe e se seu valor é um número
        $this->assertArrayHasKey('error', $json);
    }

}