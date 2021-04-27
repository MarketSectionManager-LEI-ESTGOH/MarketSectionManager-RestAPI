<?php

namespace App\Domain\User\Service;

use App\Domain\User\Repository\AreaFrigorificaRepository;
use App\Exception\ValidationException;
use phpDocumentor\Reflection\Types\Boolean;


final class AreaFrigorificaCreator
{
    private $repository;

    public function __construct(AreaFrigorificaRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createAreaFrigorifica(array $data): int
    {
        $this->validateNewAreaFrigorifica($data);

        $areafrigorifica_id = $this->repository->insertAreaFrigorifica($data);

        return $areafrigorifica_id;
    }

    public function createAreaFrigorificaLimpeza(array $data) : int
    {
        $this->validateNewAreaFrigorificaLimpeza($data);

        $areafrigorifica_row = $this->repository->insertAreaFrigorificaLimpeza($data);

        return $areafrigorifica_row;
    }

    public function createAreaFrigorificaTemperatura(array $data) : int
    {
        $this->validateNewAreaFrigorificaTemperatura($data);

        $areafrigorifica_id = $this->repository->insertAreaFrigorificaTemperatura($data);

        return $areafrigorifica_id;
    }

    public function getAreaFrigorifica()
    {
        $areafrigorifica_fetch = $this->repository->getAreaFrigorifica();

        return $areafrigorifica_fetch;
    }

    public function getAreaFrigorificaTemperaturaByUser(array $data)
    {
        $areafrigorificatemp_byUser_fetch = $this->repository->getAreaFrigorificaTemperaturaByUser($data['id']);

        return $areafrigorificatemp_byUser_fetch;
    }

    private function validateNewAreaFrigorifica(array $data): void
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