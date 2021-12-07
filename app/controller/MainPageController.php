<?php
namespace App\controller;

use JetBrains\PhpStorm\Pure;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Src\service\ArticleService;
use Src\service\UserService;

class MainPageController extends AbstractController
{
    private ArticleService $articleService;
    private UserService $userService;

    #[Pure]
    public function __construct(ServerRequestInterface $request, ResponseInterface $response, ArticleService $articleService, UserService $userService)
    {
        parent::__construct($request, $response);
        $this->articleService = $articleService;
        $this->userService = $userService;
    }

    public function index(): ResponseInterface
    {
        $articles = $this->articleService->getAllArticlesWithShortText();
        foreach ($articles as $key => $article) {
            $articles[$key]['authorName'] = $this->userService->getOne($article['authorID'])->getName();
        }
        return $this->render('blog/main', [
            'articles' => $articles
        ]);
    }
}