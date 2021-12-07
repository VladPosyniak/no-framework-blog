<?php
namespace Src\service;

use Ramsey\Uuid\Uuid;
use Src\entity\ArticleEntity;
use Src\repository\ArticleRepository;
use Src\repository\UserRepository;

class ArticleService
{
    private ArticleRepository $articleRepository;
    private UserRepository $userRepository;

    public function __construct(ArticleRepository $articleRepository, UserRepository $userRepository)
    {
        $this->articleRepository = $articleRepository;
        $this->userRepository = $userRepository;
    }

    private function getAllArticles(): array
    {
        return $this->articleRepository->getAll();
    }

    public function getAllArticlesWithShortText(): array
    {
        $articles = $this->getAllArticles();
        foreach ($articles as $key => $article) {
            $articles[$key]['text'] = mb_substr(strip_tags($article['text'], '<b><br>'), 0, 1000) . '...';
        }

        return $articles;
    }

    public function savePost(string $title, string $text, string $userID): void
    {
        $user = $this->userRepository->findOne($userID);
        $articleEntity = new ArticleEntity(Uuid::uuid4(), $title, $text, $user->getId()->toString(), time());
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