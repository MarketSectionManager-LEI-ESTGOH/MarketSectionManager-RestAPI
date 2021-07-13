<?php

use Selective\BasePath\BasePathMiddleware;
use Slim\App;
use Slim\Middleware\ErrorMiddleware;

use DI\Container;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Slim\Exception\NotFoundException;
use App\Application\Middleware\AuthMiddleware;
use Slim\Routing\RouteCollectorProxy;
use Slim\Routing\RouteContext;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Nyholm\Psr7\Factory\Psr17Factory;
use Selective\BasePath\BasePathDetector;

return function (App $app) {

    //Autentication Middleware
    $app->add(AuthMiddleware::class);

    // Parse json, form data and xml
    $app->addBodyParsingMiddleware();

    // Add the Slim built-in routing middleware
    $app->addRoutingMiddleware();




    $app->add(BasePathMiddleware::class);

    // Catch exceptions and errors
    $app->addErrorMiddleware(true, true, true);
    //$app->add(ErrorMiddleware::class);


};
