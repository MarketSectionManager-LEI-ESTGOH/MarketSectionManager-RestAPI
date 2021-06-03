<?php

use Selective\BasePath\BasePathMiddleware;
use Slim\App;
use Slim\Middleware\ErrorMiddleware;

use DI\Container;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Slim\Exception\NotFoundException;
use Slim\Routing\RouteCollectorProxy;
use Slim\Routing\RouteContext;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Nyholm\Psr7\Factory\Psr17Factory;
use Selective\BasePath\BasePathDetector;

return function (App $app) {
    // Parse json, form data and xml
    $app->addBodyParsingMiddleware();

    // Add the Slim built-in routing middleware
    $app->addRoutingMiddleware();


    /*
    //Autentication Middleware
    $mySimpleCORSMiddleware = function ($req, $res, $next) {
        $response = $next($req, $res);
        return $response
            ->withHeader('Access-Control-Allow-Origin', 'http://localhost')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    };
    $app->add($mySimpleCORSMiddleware);

    /*
    $myAuthMiddleware = function ($request, $response, $next) {
        // CORS pre-flight
        if($request->isOptions()){
            return $next($request, $response);
        }

        $public_addresses = array('/','/login');
        $the_path = $request->getUri()->getPath(); // the current path
        $this->logger->info($the_path);

        //Check if the url requested is public or protected
        if (in_array($the_path, $public_addresses)) {
            // if public, call the next middleware and continue execution normally
            return $next($request, $response);
        } else {
            // If protected url, we check if our token is valid
            // check if token exists and is still valid

            //Get the token sent from jquery
            if ($request->hasHeader('Authorization')) {
                $headers = $request->getHeader('Authorization');
                $this->logger->info("NAO E PUBLICO e TEM HEADER");
                $tokenAuth = $headers[0];




                // utilizando os tokens individuais para cada utilizador
                $sth = $this->db->prepare("SELECT * FROM user WHERE token = ? and token_expiration > NOW()");
                $sth->bindParam(1, $tokenAuth);
                $sth->execute();

                $usr = $sth->fetchAll();

                if(count($usr)<=0){
                    $this->logger->info("TOKEN ERRADO");

                    $res["auth"] = "KO";
                    $response = $response
                        ->withHeader('Access-Control-Allow-Origin', '*')
                        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
                        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                        ->withStatus(401);
                    return $response->withJson($res);

                } else {
                    $this->logger->info(" TOKEN CERTO");

                    // Authorization
                    $user_id = $usr[0]["id"]; //The ID of the logged used

                    $address_id = $request->getAttribute('id');
                    $res["auth"] = "OK";
                    $response->withJson($res);

                    // Let's see if the user is authorized to do this...
                    // This part will deppend on the app logic ...
                    // One user can only manage data about himself?
                    // Can also manage data about other users which users?

                    // TODO Finish this
                    // If the user does not have permissions - return a 403 status
                }

            } else {
                $this->logger->info("NAO E PUBLICO e NAO TEM HEADER com TOKEN");

                $res["auth"] = "KO";
                $response = $response
                    ->withHeader('Access-Control-Allow-Origin', '*')
                    ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
                    ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                    ->withStatus(401);
                return $response->withJson($res);
            }
        }
        return $next($request, $response);
    };
    $app->add($myAuthMiddleware);
    */

    $app->add(BasePathMiddleware::class);

    // Catch exceptions and errors
    $app->add(ErrorMiddleware::class);


};
