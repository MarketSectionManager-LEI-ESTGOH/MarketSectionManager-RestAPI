<?php

namespace App\Domain\User\Service;

use App\Domain\User\Repository\ValidadeRepository;
use App\Exception\ValidationException;
use phpDocumentor\Reflection\Types\Boolean;


final class ValidadeCreator
{
    private $repository;

    public function __construct(ValidadeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getProdutoByEAN(array $data)
    {
        $produto_fetch = $this->repository->getProdutoByEAN($data['ean']);

        return $produto_fetch;
    }

    public function putValidadeByProduto(array $data)
    {
        $validade_id = $this->repository->insertValidadeProduto($data);

        return $validade_id;
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
}