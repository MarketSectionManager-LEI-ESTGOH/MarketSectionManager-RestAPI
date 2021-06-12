<?php
namespace App\Action;

use App\Domain\User\Service\AreaFrigorificaCreator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class AreaFrigorificaTempraturaByUserAction
{
    private $AreaFrigorificaCreator;

    public function __construct(AreaFrigorificaCreator $AreaFrigorificaCreator){
        $this->AreaFrigorificaCreator = $AreaFrigorificaCreator;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        // Collect input from the HTTP request
        $data = (array)$request->getParsedBody();
        $data["id"] = $request->getAttribute("id");
        //print_r($data);


        // Invoke the Domain with inputs and retain the result
        $areafrigorifica_temp_ByUser = $this->AreaFrigorificaCreator->getAreaFrigorificaTemperaturaByUser($data);

        // Transform the result into the JSON representation
        $result = array();
        for($i = 0 ; $i < count($areafrigorifica_temp_ByUser); $i++){
            $result[$i] = $areafrigorifica_temp_ByUser[$i];
        }

        if($areafrigorifica_temp_ByUser == null){
            return $response->withStatus(400);
        }else{
            // Build the HTTP response
            $response->getBody()->write((string)json_encode($result));

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);
        }

    }
}


