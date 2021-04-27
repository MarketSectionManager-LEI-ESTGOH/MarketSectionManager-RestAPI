<?php

namespace App\Domain\User\Service;

use App\Domain\User\Repository\LoginCreatorRepository;
use App\Exception\ValidationException;

/**
 * Service.
 */
final class LoginCreator
{

    private $repository;

    public function __construct(LoginCreatorRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Login Verification method
     *
     * @param array $data input from user
     * @return array|null if user found and correct password | if user not found or wrong password given
     */
    public function LoginUser(array $data): ?array
    {
        // Input validation
        $this->validateNewLogin($data);
        $loginInfo = $this->repository->searchUser($data);


        if($loginInfo != null){
            return $loginInfo;
        }
        //Null if ser not found
        return null;
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
    private function validateNewLogin(array $data): void
    {
        $errors = [];

        if (empty($data['num_interno'])) {
            $errors['num_interno'] = 'Input required';
        }

        if (empty($data['password'])) {
            $errors['password'] = 'Input required';
        }


        if ($errors) {
            throw new ValidationException('Please check your input', $errors);
        }
    }
}

