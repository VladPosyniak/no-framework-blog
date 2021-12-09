<?php
namespace Src\entity;

use DomainException;
use JetBrains\PhpStorm\ArrayShape;
use Ramsey\Uuid\UuidInterface;

class UserEntity
{
    private UuidInterface $id;
    private string $name;
    private string $email;
    private string $passwordHash;
    private int $createdTimestamp;

    public function __construct(UuidInterface $id, string $name, string $email, string $passwordHash, int $createdTimestamp)
    {
        if ($this->validateEmail($email) && $this->validateName($name)) {
            $this->id = $id;
            $this->name = $name;
            $this->email = $email;
            $this->passwordHash = $passwordHash;
            $this->createdTimestamp = $createdTimestamp;
        }
    }

    public static function hashPassword(string $password): string {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    #[ArrayShape(['id' => "string", 'name' => "string", 'email' => "string", 'passwordHash' => 'string', 'createdTimestamp' => 'int'])]
    public function toArray(): array
    {
        return [
            'id' => $this->id->toString(),
            'name' => $this->name,
            'email' => $this->email,
            'passwordHash' => $this->passwordHash,
            'createdTimestamp' => $this->createdTimestamp
        ];
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    public function passwordHashEqualsTo(string $passwordHash): bool
    {
        return $this->passwordHash === $passwordHash;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    private function validateEmail(string $email): bool
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }

        throw new DomainException('Incorrect email ' . $email);
    }

    private function validateName(string $name): bool
    {
        $strlen = strlen($name);
        if ($strlen <= 16 && $strlen > 2) {
            return true;
        }

        throw new DomainException('Incorrect name ' . $name);
    }
}