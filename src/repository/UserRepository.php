<?php

namespace Src\repository;

use App\db\Connection;
use DomainException;
use Ramsey\Uuid\Uuid;
use Src\entity\UserEntity;

class UserRepository
{
    public const TABLE_NAME = 'user';

    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getAll(): array
    {
        return $this->connection->getAll(self::TABLE_NAME);
    }

    public function findOne(string $id): UserEntity
    {
        $user = $this->connection->findOne(self::TABLE_NAME, $id);
        return new UserEntity(Uuid::fromString($user['id']), $user['name'], $user['email'], $user['passwordHash'], $user['createdTimestamp']);
    }

    public function findByEmail(string $email): UserEntity
    {
        $users = $this->connection->getAll(self::TABLE_NAME);
        foreach ($users as $user) {
            if ($user['email'] === $email) {
                return new UserEntity(Uuid::fromString($user['id']), $user['name'], $user['email'], $user['passwordHash'], $user['createdTimestamp']);
            }
        }

        throw new DomainException('User not found');
    }

    public function save(UserEntity $userEntity): void
    {
        $this->connection->insert(self::TABLE_NAME, $userEntity->getID()->toString(), $userEntity->toArray());
    }

    public function delete(string $id): void
    {
        $this->connection->delete(self::TABLE_NAME, $id);
    }
}