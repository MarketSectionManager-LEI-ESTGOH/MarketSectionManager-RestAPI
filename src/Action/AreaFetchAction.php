<?php
namespace App\Action;

use App\Domain\User\Service\AreaCreator;
use App\Domain\User\Service\AreaFrigorificaCreator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class AreaFetchAction
{
    private $AreaFetchCreator;

    public function __construct(AreaCreator $AreaFetchCreator)
    {
        $this->AreaFetchCreator = $AreaFetchCreator;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {


        // Invoke the Domain with inputs and retain the result
        $area_fetch = $this->AreaFetchCreator->getArea();

        // Transform the result into the JSON representation
        $result = array();
        for($i = 0 ; $i < count($area_fetch); $i++){
            $result[$i] = $area_fetch[$i];
        }

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($result));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
