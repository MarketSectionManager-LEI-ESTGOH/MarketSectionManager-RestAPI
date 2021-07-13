<?php

namespace App\Domain\User\Service;

use App\Domain\User\Repository\LoginCreatorRepository;
use App\Domain\User\Repository\RastreabilidadeRepository;
use App\Exception\ValidationException;

/**
 * Service.
 */
final class RastreabilidadeCreator
{

    private $repository;

    public function __construct(RastreabilidadeRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Login Verification method
     *
     * @param array $data input from user
     * @return array|null if user found and correct password | if user not found or wrong password given
     */
    public function addRastreabilidade(array $data): int
    {
        // Input validation
        $this->validateNewRastreabilidade($data);
        $id = $this->repository->addRastreabilidade($data);
        return $id;
    }

    /**
     * Input validation.
     *
     * @param array $data The form data
     *
     * @throws ValidationException
     *
     * @return void
     */
    private function validateNewRastreabilidade(array $data): void
    {
        $errors = [];

        if (empty($data['lote'])) {
            $errors['lote'] = 'Input required';
        }

        if (empty($data['produto_id'])) {
            $errors['produto_id'] = 'Input required';
        }

        if (empty($data['user_id'])) {
            $errors['user_id'] = 'Input required';
        }

        if (empty($data['fornecedor_id'])) {
            $errors['fornecedor_id'] = 'Input required';
        }

        if (empty($data['origem'])) {
            $errors['origem'] = 'Input required';
        }

        if ($errors) {
            throw new ValidationException('Please check your input', $errors);
        }
    }
}

