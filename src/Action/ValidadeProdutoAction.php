<?php
namespace App\Action;

use App\Domain\User\Service\ValidadeCreator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ValidadeProdutoAction
{
    private $ValidadeCreator;

    public function __construct(ValidadeCreator $ValidadeCreator)
    {
        $this->ValidadeCreator = $ValidadeCreator;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        // Collect input from the HTTP request
        $data = (array)$request->getParsedBody();


        // Invoke the Domain with inputs and retain the result
        $validade_id = $this->ValidadeCreator->putValidadeByProduto($data);

        $result = [
            '$validade_id' => $validade_id
        ];

        // Transform the result into the JSON representation

        if($validade_id == -1){
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(400);
        }else{
            // Build the HTTP response
            $response->getBody()->write((string)json_encode($result));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(201);
        }
    }
}