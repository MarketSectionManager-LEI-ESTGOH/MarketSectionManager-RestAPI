<?php
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response as Response;
use Slim\App;

return function (App $app) {

    $app->get('/', \App\Action\HomeAction::class)->setName('home');

    $app->get('/hh', function (ServerRequestInterface $request, ResponseInterface $response) {
        $response->getBody()->write('Hello World');
        return $response;
    })->setName('home');

    $app->post('/users', \App\Action\UserCreateAction::class);


    //Login User
    //$app->post('/login', \App\Action\LoginAction::class);
    // USER autentication
    $app->post('/login', function ($request, $response) {
        $pdo = $this->get(PDO::class);

        $input = json_decode(file_get_contents('php://input'), true);

        $sth = $pdo->prepare("SELECT * FROM user WHERE num_interno = ?");
        $sth->bindParam(1, $input['num_interno']);
        $sth->execute();

        $usr = $sth->fetchAll();

        $res = array();
        if(count($usr)>0){

            //print($input['password'].'\n');
            //print($usr[0]["password"].'\n');
            //print($input['password'] == $usr[0]["password"]);

            if($input['password'] == $usr[0]["password"]){
                $res["auth"] = "OK";
                //gerar random token
                $res["token"] = bin2hex(openssl_random_pseudo_bytes(8));
                $res["id"] = $usr[0]['id'];
                $res["tipo"] = $usr[0]['tipo'];
                $res["nome"] = $usr[0]['nome'];
                $res["num_interno"] = $usr[0]['num_interno'];
                $res["password"] = $usr[0]['password'];
                $res["email"] = $usr[0]['email'];

                //update do token e da validade to token
                $sth = $pdo->prepare("UPDATE user SET token = ?, token_expiration = DATE_ADD(NOW(), INTERVAL 30 MINUTE) WHERE num_interno = ?");
                $sth->bindParam(1, $res["token"]);
                $sth->bindParam(2, $res["num_interno"]);
                $sth->execute();
            } else {
                $res["auth"] = "KO";
            }
        } else{
            $res["auth"] = "KO";
        }
        $r = json_encode($res);
        $response->getBody()->write($r);
        return $response->withHeader('Content-Type', 'application/json');
    })->setName('login');

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

    $app->get('/produto/validade/{ean}', \App\Action\ValidadeProductFetchAction::class)->setName('produto_validade');

    $app->post('/produto/validade', \App\Action\ValidadeProdutoAction::class);

    $app->get('/area/componetes/user/{id}', \App\Action\LastComponentesLimpezaUser::class);

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



