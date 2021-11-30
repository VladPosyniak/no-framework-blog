<?php
namespace Src\service;

use Src\entity\ArticleEntity;
use Src\repository\ArticleRepository;

class ArticleService
{
    private ArticleRepository $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function getAllArticles(): array
    {
        return $this->articleRepository->getAll();
    }

    public function savePost(ArticleEntity $articleEntity): void
    {
        $this->articleRepository->save($articleEntity);
    }

    public function getArticle(string $id): array
    {
        return $this->articleRepository->findOne($id)->toArray();
    }

    public function deleteArticle(string $id): void
    {
        $this->articleRepository->delete($id);
    }

}