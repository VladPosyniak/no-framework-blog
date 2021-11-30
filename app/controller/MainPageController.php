<?php
namespace App\controller;

use JetBrains\PhpStorm\Pure;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Src\service\ArticleService;

class MainPageController extends AbstractController
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
        return $this->render('blog/main', [
            'articles' => $this->articleService->getAllArticles()
        ]);
    }
}