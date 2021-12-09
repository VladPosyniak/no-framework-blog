<?php
namespace Tests;

use DomainException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Src\entity\ArticleEntity;

class ArticleTest extends TestCase
{
    public function testCanBeCreated()
    {
        $id = Uuid::uuid4();
        $date = '2021-01-01 11:11:11';
        $article = new ArticleEntity($id, 'Title', 'Text', 1, strtotime($date));
        $this->assertEquals([
            'id' => $id->toString(),
            'title' => 'Title',
            'text' => 'Text',
            'authorID' => 1,
            'created' => $date], $article->toArray());
    }

    public function testTitleCantBeLonger20Chars()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Title length must be less than 20 chars');
        new ArticleEntity(Uuid::uuid4(), 'Looooooooooooooooong tirle', 'Text', 1, time());
    }

}