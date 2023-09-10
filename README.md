# api-transacoes
API de Transações utilizando PHP 8.2, Lumem 10, SQLite e PHPUnit.



Rotas disponíveis:


$router->post('/conta', 'ContaController@create');          // O endpoint "/conta" deve criar e fornecer informações sobre o número da conta e o saldo 


$router->get('/conta', 'ContaController@get');              // "


$router->post('/quinhentos', 'ContaController@quinhentos'); // Crie um endpoint na API que permita a criação de uma nova conta com um saldo inicial de R$500.


$router->post('/transacao', 'TransacaoController@create');  // O endpoint "/transacao" será responsável por realizar diversas operações financeiras. 



Comandos para rodar o projeto: 


git clone https://github.com/lucasgarciamarcos/api-transacoes.git 



composer self-update                // Certifica versionamento atual do Composer 


composer install                    // Instala dependências Lumem 


php artisan migrate                 // Faz o migrate do DB 


php -S localhost:8000 -t public     // Up do projeto em localhost 


./vendor/bin/phpunit                // Roda os testes unitários 

