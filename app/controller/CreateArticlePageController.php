<?php

namespace App\controller;

use JetBrains\PhpStorm\Pure;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Ramsey\Uuid\Uuid;
use Src\entity\ArticleEntity;
use Src\service\ArticleService;

class CreateArticlePageController extends AbstractController
{
    private ArticleService $articleService;

    #[Pure]
    public function __construct(ServerRequestInterface $request, ResponseInterface $response, ArticleService $articleService)
    {
        parent::__construct($request, $response);
        $this->articleService = $articleService;
    }

    public function index(): ResponseInterface
    {
        if ($this->request->getMethod() === 'POST') {
            $body = $this->request->getParsedBody();
            $this->articleService->savePost(new ArticleEntity(Uuid::uuid4(), $body['title'], $body['text'], 1, time()));
            return $this->render('success-message', ['message' => 'Article created!']);
        }
        return $this->render('blog/create-article', [
            'articles' => $this->articleService->getAllArticles()
        ]);
    }
}