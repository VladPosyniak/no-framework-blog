<?php
namespace Tests\service;

use App\db\Connection;
use DomainException;
use PHPUnit\Framework\TestCase;
use Src\entity\UserEntity;
use Src\service\UserService;
use Tests\TestHelper;

class UserServiceTest extends TestCase
{
    use TestHelper;

    public function testCorrectUserRegistration(): void
    {
        $this->setConfig();
        $DI = $this->getDI();
        $connection = $this->createMock(Connection::class);
        $connection->method('insert');
        $DI->set(Connection::class, $connection);
        $connection->expects($this->once())->method('insert');
        $userService = $DI->get(UserService::class);
        $userID = $userService->register('Vlad',
                                         'vladposynyak@gmail.com',
                                         UserEntity::hashPassword('123'));
        $this->assertNotEmpty($userID);
    }

    public function testCorrectUserLogin(): void
    {
        $this->setConfig();
        $DI = $this->getDI();
        $connection = $this->createMock(Connection::class);
        $connection->method('getAll')->willReturn([
            'b7c8fc85-195f-4153-9896-4718c1e32d79' => [
                'id' => 'b7c8fc85-195f-4153-9896-4718c1e32d79',
                'name' => 'Vlad',
                'email' => 'vladposynyak@gmail.com',
                'passwordHash' => UserEntity::hashPassword('123456'),
                'createdTimestamp' => time()
            ]
                                                  ]);
        $DI->set(Connection::class, $connection);
        $connection->expects($this->once())->method('getAll');
        $userService = $DI->get(UserService::class);
        $userID = $userService->login('vladposynyak@gmail.com', '123456');
        $this->assertNotEmpty($userID);
    }

    public function testIncorrectPasswordLogin(): void
    {
        $this->setConfig();
        $DI = $this->getDI();
        $connection = $this->createMock(Connection::class);
        $connection->method('getAll')->willReturn([
            'b7c8fc85-195f-4153-9896-4718c1e32d79' => [
                'id' => 'b7c8fc85-195f-4153-9896-4718c1e32d79',
                'name' => 'Vlad',
                'email' => 'vladposynyak@gmail.com',
                'passwordHash' => UserEntity::hashPassword('123456'),
                'createdTimestamp' => time()
            ]
                                                  ]);
        $DI->set(Connection::class, $connection);
        $connection->expects($this->once())->method('getAll');
        $userService = $DI->get(UserService::class);

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Incorrect password');
        $userService->login('vladposynyak@gmail.com', 'incorrect');
    }

}