<?php

namespace Tests\service;

use App\db\Connection;
use PHPUnit\Framework\TestCase;
use Src\entity\UserEntity;
use Src\service\ArticleService;
use Tests\TestHelper;

class ArticleServiceTest extends TestCase
{
    use TestHelper;

    public function testDeleteArticle()
    {
        $this->setConfig();
        $DI = $this->getDI();
        $connection = $this->createMock(Connection::class);
        $connection->method('delete');
        $DI->set(Connection::class, $connection);
        $connection->expects($this->once())->method('delete');
        $articleService = $DI->get(ArticleService::class);
        $articleService->deleteArticle('article-id');
    }

    public function testCorrectSaveArticle()
    {
        $this->setConfig();
        $DI = $this->getDI();
        $connection = $this->createMock(Connection::class);
        $connection->method('findOne')->willReturn([
                                                       'id' => 'b7c8fc85-195f-4153-9896-4718c1e32d79',
                                                       'name' => 'Vlad',
                                                       'email' => 'vladposynyak@gmail.com',
                                                       'passwordHash' => UserEntity::hashPassword('123456'),
                                                       'createdTimestamp' => time()
                                                   ]);
        $connection->method('insert');
        $connection->expects($this->once())->method('insert');
        $DI->set(Connection::class, $connection);
        $connection->expects($this->once())->method('findOne');
        $articleService = $DI->get(ArticleService::class);
        $articleService->savePost('Title', 'Title text', 'b7c8fc85-195f-4153-9896-4718c1e32d79');
    }
}