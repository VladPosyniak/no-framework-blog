<?php

namespace App\controller;

use DI\NotFoundException;
use JetBrains\PhpStorm\Pure;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use SmartyException;
use Src\service\ArticleService;
use Src\service\UserService;

class ArticlePageController extends AbstractController
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

    /**
     * @throws SmartyException
     * @throws NotFoundException
     */
    public function index(): ResponseInterface
    {
        if (isset($this->request->getQueryParams()['id']) === false) {
            throw new NotFoundException();
        }
        $article = $this->articleService->getArticle($this->request->getQueryParams()['id']);
        $author = $this->userService->getOne($article->getAuthorId());
        return $this->render('blog/article', [
            'article' => $article->toArray(),
            'author' => $author->toArray()
        ]);
    }
}