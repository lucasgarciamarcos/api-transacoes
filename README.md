# api-transacoes
API de Transações utilizando PHP 8.2, Lumem 10, SQLite e PHPUnit.
\n
Rotas disponíveis:
$router->post('/conta', 'ContaController@create');          // O endpoint "/conta" deve criar e fornecer informações sobre o número da conta e o saldo \n
$router->get('/conta', 'ContaController@get');              // " \n
$router->post('/quinhentos', 'ContaController@quinhentos'); // Crie um endpoint na API que permita a criação de uma nova conta com um saldo inicial de R$500. \n
$router->post('/transacao', 'TransacaoController@create');  // O endpoint "/transacao" será responsável por realizar diversas operações financeiras. \n

Comandos para rodar o projeto: \n

git clone https://github.com/lucasgarciamarcos/api-transacoes.git \n

composer self-update                // Certifica versionamento atual do Composer \n
composer install                    // Instala dependências Lumem \n
php artisan migrate                 // Faz o migrate do DB \n
php -S localhost:8000 -t public     // Up do projeto em localhost \n
./vendor/bin/phpunit                // Roda os testes unitários \n