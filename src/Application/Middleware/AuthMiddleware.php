<?php
declare(strict_types=1);

namespace App\Application\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use Slim\Routing\RouteContext;
use Slim\Exception\HttpNotFoundException;

use PDO;

class AuthMiddleware
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $routeContext = RouteContext::fromRequest($request);
        $route = $routeContext->getRoute();
        // return NotFound for non existent route
        if (empty($route)) {
            throw new HttpNotFoundException($request);
        }
    
        $name = $route->getName();

        $publicRoutesArray = array('login','home');
        
        // se a rota atual não estiver na lista de rotas públicas
        if(!in_array($name, $publicRoutesArray))
        {

            if(!isset($request->getHeader('Authorization')[0])){
                // The token was not present
                throw new \Slim\Exception\HttpForbiddenException($request);
            }

            $authorization = explode(" ", $request->getHeader('Authorization')[0]);
            //print_r($authorization);



            /* Utilizando uma API key estática

            $api_secret = "e58598f564e6dd2b";// The secret
            $user_secret = $authorization[0];// The secret provided by the user

            if($api_secret !== $user_secret){
                throw new \Slim\Exception\HttpForbiddenException($request);
            } else{
                // The key is correct
                return $handler->handle($request);
            }*/

            $sth = $this->pdo->prepare("SELECT * FROM user WHERE token = ? AND token_expiration > NOW()");
            $sth->bindParam(1, $authorization[0]);
            $sth->execute();

            $usr = $sth->fetchAll();

            if(empty($usr)){
                throw new \Slim\Exception\HttpForbiddenException($request);
            } else{
                // The token is valid
                //update da validade to token
                $sth = $this->pdo->prepare("UPDATE user SET token_expiration = DATE_ADD(NOW(), INTERVAL 30 MINUTE) WHERE id = ?");
                $sth->bindParam(1, $usr[0]["id"]);
                $sth->execute();
                return $handler->handle($request);
            }


            throw new \Slim\Exception\HttpForbiddenException($request);
        } else {
            //caso contrário continua a fazer o que tem que ser feito
            return $handler->handle($request);
        }


        /*
        $response = $handler->handle($request);
        $existingContent = (string) $response->getBody();
    
        $response = new Response();
        $response->getBody()->write('BEFORE' . $existingContent);
    
        return $response;
        */
    }
}
