<?php

use App\Models\Db;
use App\Controllers\Funcionario;
use App\Controllers\Ponto;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Selective\BasePath\BasePathMiddleware;
use Slim\Factory\AppFactory;

use Slim\Exception\HttpNotFoundException;


require_once __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->addRoutingMiddleware();
$app->add(new BasePathMiddleware($app));
$app->addBodyParsingMiddleware();
$app->addErrorMiddleware(true, true, true);

$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$app->add(function ($request, $handler) {
    $response = $handler->handle($request);
    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});


$app->get('/funcionario', function (Request $request, Response $response) {
    return Funcionario::getAll($response);
});

$app->get('/funcionario/{id}', function (Request $request, Response $response, $args) {
    $id = $args['id'];
    return Funcionario::getById($response, $id);
});

$app->post('/funcionario', function (Request $request, Response $response) {
    return Funcionario::create($request, $response);
});

$app->put('/funcionario/{id}', function (Request $request, Response $response, $args) {
    $id = $args['id'];
    return Funcionario::update($request, $response, $id);
});

$app->delete('/funcionario/{id}', function (Request $request, Response $response, $args) {
    $id = $args['id'];
    return Funcionario::delete($response, $id);
});

$app->post('/ponto', function (Request $request, Response $response) {
    return Ponto::create($request, $response);
});

$app->delete('/ponto/{id}', function (Request $request, Response $response, $args) {
    $id = $args['id'];
    return Ponto::delete($response, $id);
});

$app->get('/ponto', function (Request $request, Response $response) {
    return Ponto::getAll($response);
});

$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
    throw new HttpNotFoundException($request);
});

$app->run();
