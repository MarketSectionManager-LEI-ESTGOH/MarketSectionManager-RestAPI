<?php
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response as Response;
use Slim\App;

return function (App $app) {

    $app->get('/', \App\Action\HomeAction::class)->setName('home');

    $app->get('/hello', function (ServerRequestInterface $request, ResponseInterface $response) {
        $response->getBody()->write('Hello World');
        return $response;
    });

    $app->post('/users', \App\Action\UserCreateAction::class);

    //Login User
    $app->post('/login', \App\Action\LoginAction::class);

    // /area/frigorifica
    $app->post('/area/frigorifica', \App\Action\AreaFrigorificaAction::class);

    $app->post('/area/frigorifica/temperatura', \App\Action\AreaFrigorificaTemperaturaAction::class);

    $app->put('/limpeza/frigorifica/{id}', \App\Action\AreaFrigorificaLimpezaAction::class);

    $app->get('/area/frigorifica', \App\Action\AreaFrigorificaFetchAction::class);

    $app->get('/area/frigorifica/user/{id}', \App\Action\AreaFrigorificaTempraturaByUserAction::class);

    $app->post('/rastreabilidade', \App\Action\RastreabilidadeAction::class);

    $app->get('/area', \App\Action\AreaFetchAction::class);

    $app->get('/area/componentes/{area_num}', \App\Action\ComponentesAreaAction::class);

    $app->post('/area/componentes/{id}', \App\Action\AreaLimpezaAction::class);

    $app->get('/produto/validade/{ean}', \App\Action\ValidadeProductFetchAction::class);

    $app->get('/ggg', function (ServerRequestInterface $request, ResponseInterface $response) {

        $data1 = array();
        $data2 = array('name' => 'Bobbbb', 'age' => 4000);
        $data3 = array('name' => 'B', 'age' => 4);
        array_push($data1, $data2,$data3);
        $response->getBody()->write((string)json_encode($data1));
        $response = $response->withHeader('Content-Type', 'application/json');
        return $response;
    });
};



