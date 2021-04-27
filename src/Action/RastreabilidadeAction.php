<?php
namespace App\Action;

use App\Domain\User\Service\RastreabilidadeCreator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class RastreabilidadeAction
{
    private $RastreabilidadeCreator;

    public function __construct(RastreabilidadeCreator $RastreabilidadeCreator){
        $this->RastreabilidadeCreator = $RastreabilidadeCreator;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        // Collect input from the HTTP request
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $rastreabilidade_id = $this->RastreabilidadeCreator->addRastreabilidade($data);


        // Transform the result into the JSON representation
        $result = [
            'rastreabilidade_id' => $rastreabilidade_id
        ];

        $response->getBody()->write((string)json_encode($result));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }
}
