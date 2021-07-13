<?php
namespace App\Action;

use App\Domain\User\Service\AreaCreator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class AreaLimpezaAction
{
    private $AreaCreator;

    public function __construct(AreaCreator $AreaCreator){
        $this->AreaCreator = $AreaCreator;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        // Collect input from the HTTP request
        $data = (array)$request->getParsedBody();
        $id = $request->getAttribute("id");
        //print_r($data);


        // Invoke the Domain with inputs and retain the result
        $row = $this->AreaCreator->putAreaCompenetesLimpos($data, $id);

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($row));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }
}