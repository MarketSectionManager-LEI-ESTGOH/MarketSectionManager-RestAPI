<?php

namespace App\Action;

use App\Domain\User\Service\LoginCreator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class LoginAction
{
    private $loginCreator;

    public function __construct(LoginCreator $loginCreator)
    {
        $this->loginCreator = $loginCreator;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        // Collect input from the HTTP request
        $data = (array)$request->getParsedBody();
        $loginInfo = $this->loginCreator->LoginUser($data);

        if($loginInfo != null){
            $result = [
                'id' => $loginInfo[0]['id'],
                'tipo' => $loginInfo[0]['tipo'],
                'nome' => $loginInfo[0]['nome'],
                'num_interno' => $loginInfo[0]['num_interno'],
                'password' => $loginInfo[0]['password'],
                'email' => $loginInfo[0]['email']
            ];
            $response->getBody()->write((string)json_encode($result));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);
        }else{
            $response->getBody()->write((string)json_encode("null"));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(401);
        }
    }
}