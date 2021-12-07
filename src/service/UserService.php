<?php

namespace Src\service;

use DomainException;
use Ramsey\Uuid\Uuid;
use Src\entity\UserEntity;
use Src\repository\UserRepository;

class UserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(string $name, string $email, string $password): string
    {
        $userEntity = new UserEntity(Uuid::uuid4(), $name, $email, password_hash($password, PASSWORD_DEFAULT), time());

        $this->userRepository->save($userEntity);
        return $userEntity->getId()->toString();
    }

    public function login(string $email, string $password): string
    {
        $userEntity = $this->userRepository->findByEmail($email);
        if ($userEntity->passwordHashEqualsTo(password_hash($password, PASSWORD_DEFAULT))) {
            return $userEntity->getId()->toString();
        }

        throw new DomainException('Incorrect password');
    }

    public function getOne(string $userID): UserEntity
    {
        try {
            return $this->userRepository->findOne($userID);
        } catch (DomainException) {
            throw new DomainException('User not found');
        }
    }
}