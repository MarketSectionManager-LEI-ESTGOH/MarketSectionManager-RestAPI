<?php
namespace App\Action;

use App\Domain\User\Service\AreaFrigorificaCreator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class AreaFrigorificaAction
{
    private $AreaFrigorificaCreator;

    public function __construct(AreaFrigorificaCreator $AreaFrigorificaCreator)
    {
        $this->AreaFrigorificaCreator = $AreaFrigorificaCreator;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        // Collect input from the HTTP request
        $data = (array)$request->getParsedBody();


        // Invoke the Domain with inputs and retain the result
        $areafrigorifica_id = $this->AreaFrigorificaCreator->createAreaFrigorifica($data);

        // Transform the result into the JSON representation
        $result = [
            'areafrigorifica_id' => $areafrigorifica_id
        ];

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($result));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }
}
