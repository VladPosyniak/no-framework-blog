<?php
namespace Src\repository;

use App\db\Connection;
use Ramsey\Uuid\Uuid;
use Src\entity\ArticleEntity;

class ArticleRepository
{
    public const TABLE_NAME = 'article';

    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getAll(): array
    {
        return $this->connection->getAll(self::TABLE_NAME);
    }

    public function findOne(string $id): ArticleEntity
    {
        $article = $this->connection->findOne(self::TABLE_NAME, $id);
        return new ArticleEntity(Uuid::fromString($article['id']), $article['title'], $article['text'], $article['authorID'], strtotime($article['created']));
    }

    public function save(ArticleEntity $articleEntity): void
    {
        $this->connection->insert(self::TABLE_NAME, $articleEntity->getID()->toString(), $articleEntity->toArray());
    }

    public function delete(string $id): void
    {
        $this->connection->delete(self::TABLE_NAME, $id);
    }
}