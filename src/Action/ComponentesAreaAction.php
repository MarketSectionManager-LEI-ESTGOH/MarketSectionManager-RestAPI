<?php
namespace App\Action;

use App\Domain\User\Service\AreaCreator;
use App\Domain\User\Service\AreaFrigorificaCreator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ComponentesAreaAction
{
    private $AreaCreator;

    public function __construct(AreaCreator $AreaCreator)
    {
        $this->AreaCreator = $AreaCreator;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {

        $data = (array)$request->getParsedBody();
        $data["area_num"] = $request->getAttribute("area_num");


        // Invoke the Domain with inputs and retain the result
        $componentes_fetch = $this->AreaCreator->getComponentesArea($data);

        // Transform the result into the JSON representation
        $result = array();
        for($i = 0 ; $i < count($componentes_fetch); $i++){
            $result[$i] = $componentes_fetch[$i];
        }

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($result));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);


    }
}
