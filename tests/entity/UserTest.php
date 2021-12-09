<?php

namespace Tests;

use DomainException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Src\entity\UserEntity;

class UserTest extends TestCase
{
    public function testCanBeCreated()
    {
        $id = Uuid::uuid4();
        $date = '2021-01-01 11:11:11';
        $name = 'User';
        $email = 'test@gmail.com';
        $passwordHash = UserEntity::hashPassword(123);
        $user = new UserEntity($id, $name, $email, $passwordHash, strtotime($date));
        $this->assertEquals([
                                'id' => $id->toString(),
                                'name' => $name,
                                'email' => $email,
                                'passwordHash' => $passwordHash,
                                'createdTimestamp' => strtotime($date)], $user->toArray());
    }

    public function testCreateWithInvalidEmail()
    {
        $email = 'wronemail';
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Incorrect email ' . $email);
        $id = Uuid::uuid4();
        $date = '2021-01-01 11:11:11';
        $name = 'User';
        $passwordHash = UserEntity::hashPassword(123);
        new UserEntity($id, $name, $email, $passwordHash, strtotime($date));
    }

    public function testCreateWithTooLongName()
    {
        $name = 'Looooooooooon name';
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Incorrect name ' . $name);
        $id = Uuid::uuid4();
        $date = '2021-01-01 11:11:11';
        $passwordHash = UserEntity::hashPassword(123);
        new UserEntity($id, $name, 'email@gmail.com', $passwordHash, strtotime($date));
    }


    public function testCreateWithTooShortName()
    {
        $name = 's';
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Incorrect name ' . $name);
        $id = Uuid::uuid4();
        $date = '2021-01-01 11:11:11';
        $passwordHash = UserEntity::hashPassword(123);
        new UserEntity($id, $name, 'email@gmail.com', $passwordHash, strtotime($date));
    }

}