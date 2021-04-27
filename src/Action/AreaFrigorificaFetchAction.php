<?php
namespace App\Action;

use App\Domain\User\Service\AreaFrigorificaCreator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class AreaFrigorificaFetchAction
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


        // Invoke the Domain with inputs and retain the result
        $areafrigorifica_fetch = $this->AreaFrigorificaCreator->getAreaFrigorifica();

        // Transform the result into the JSON representation
        $result = array();
        for($i = 0 ; $i < count($areafrigorifica_fetch); $i++){
            $result[$i] = $areafrigorifica_fetch[$i];
        }
        /*
        $result = [
            'id' => $areafrigorifica_fetch['id'],
            'numero' => $areafrigorifica_fetch['numero'],
            'designacao' => $areafrigorifica_fetch['designacao'],
            'fabricante' => $areafrigorifica_fetch['fabricante'],
            'd_t_adicao' => $areafrigorifica_fetch['d_t_adicao'],
            'tem_min' => $areafrigorifica_fetch['tem_min'],
        'tem_max' => $areafrigorifica_fetch['tem_max']
        ];
        */

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($result));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }
}