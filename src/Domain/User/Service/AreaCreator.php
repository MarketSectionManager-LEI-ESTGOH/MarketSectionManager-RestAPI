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

    private function validateArea(array $data): void
    {
        $errors = [];

        if (empty($data['numero'])) {
            $errors['numero'] = 'Input required';
        }

        if (empty($data['designacao'])) {
            $errors['designacao'] = 'Input required';
        }

        if (empty($data['fabricante'])) {
            $errors['fabricante'] = 'Input required';
        }

        if (empty($data['tem_min'])) {
            $errors['tem_min'] = 'Input required';
        }

        if (empty($data['tem_max'])) {
            $errors['tem_max'] = 'Input required';
        }

        if ($errors) {
            throw new ValidationException('Please check your input', $errors);
        }
    }

    private function validateNewAreaFrigorificaLimpeza(array $data): void
    {
        $errors = [];

        if (empty($data['user_limpeza'])) {
            $errors['user_limpeza'] = 'Input required';
        }

        if ($errors) {
            throw new ValidationException('Please check your input', $errors);
        }
    }

    private function validateNewAreaFrigorificaTemperatura(array $data): void
    {
        $errors = [];

        if (empty($data['user_id'])) {
            $errors['user_id'] = 'Input required';
        }

        if (empty($data['temperatura'])) {
            $errors['temperatura'] = 'Input required';
        }

        if (empty($data['area_frigorifica_id'])) {
            $errors['area_frigorifica_id'] = 'Input required';
        }

        if ($errors) {
            throw new ValidationException('Please check your input', $errors);
        }
    }
}
