<?php

namespace App\Domain\User\Service;

use App\Domain\User\Repository\AreaFrigorificaRepository;
use App\Domain\User\Repository\AreaRepository;
use App\Exception\ValidationException;
use phpDocumentor\Reflection\Types\Boolean;


final class AreaCreator
{
    private $repository;

    public function __construct(AreaRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getArea()
    {
        $areaList = $this->repository->getAreas();

        return $areaList;
    }

    public function getComponentesArea(array $data)
    {
        $componentesList = $this->repository->getComponentesArea($data['area_num']);
        return $componentesList;
    }

    public function putAreaCompenetesLimpos(array $data, int $id)
    {
        $componentes_row = $this->repository->putAreaCompenetesLimpos($data, $id);
        //print_r($componentes_row);
        return $componentes_row;
    }

    public function getComponentesLimposByUser(int $id)
    {
        $componentesList = $this->repository->getComponentesLimposByUser($id);
        return $componentesList;
    }

    private function validateComponentesArea(array $data): void
    {
        $errors = [];

        if (empty($data['area_num'])) {
            $errors['area_num'] = 'Input required';
        }

        if ($errors) {
            throw new ValidationException('Please check your input', $errors);
        }
    }
}
