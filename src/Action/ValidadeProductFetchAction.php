<?php
namespace App\Action;

use App\Domain\User\Service\ValidadeCreator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ValidadeProductFetchAction
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
        $data["ean"] = $request->getAttribute("ean");


        // Invoke the Domain with inputs and retain the result
        $validade_id = $this->ValidadeCreator->getProdutoByEAN($data);

        // Transform the result into the JSON representation
        $result = [
            'validade_id' => $validade_id
        ];

        if(sizeof($validade_id) == 0){
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(400);
        }else{
            // Build the HTTP response
            $response->getBody()->write((string)json_encode($result));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);
        }
    }
}