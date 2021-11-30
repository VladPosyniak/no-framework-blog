<?php

namespace App\controller;

use DI\NotFoundException;
use JetBrains\PhpStorm\Pure;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use SmartyException;
use Src\service\ArticleService;

class ArticlePageController extends AbstractController
{
    private ArticleService $articleService;

    #[Pure]
    public function __construct(ServerRequestInterface $request, ResponseInterface $response, ArticleService $articleService)
    {
        parent::__construct($request, $response);
        $this->articleService = $articleService;
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
        return $this->render('blog/article', $article);
    }
}