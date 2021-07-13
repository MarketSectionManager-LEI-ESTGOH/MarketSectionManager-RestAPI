<?php


namespace App\Action;


use App\Domain\User\Service\AreaCreator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class LastComponentesLimpezaUser
{
    private $AreaCreator;

    public function __construct(AreaCreator $AreaCreator){
        $this->AreaCreator = $AreaCreator;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        // Collect input from the HTTP request
        $data = (array)$request->getParsedBody();
        $data["id"] = $request->getAttribute("id");
        //print_r($data);


        // Invoke the Domain with inputs and retain the result
        $area_limpeza_ByUser = $this->AreaCreator->getComponentesLimposByUser($data["id"]);

        // Transform the result into the JSON representation
        $result = array();
        for($i = 0 ; $i < count($area_limpeza_ByUser); $i++){
            $result[$i] = $area_limpeza_ByUser[$i];
        }

        if($area_limpeza_ByUser == null){
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