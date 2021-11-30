<?php

namespace App\controller;

use JetBrains\PhpStorm\Pure;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Src\service\ArticleService;

class DeleteArticlePageController extends AbstractController
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
        $articleID = $this->request->getQueryParams()['id'];
        $this->articleService->deleteArticle($articleID);
        return $this->render('success-message', [
            'message' => 'Article deleted!'
        ]);
    }
}