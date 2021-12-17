<?php

namespace App\controller;

use DomainException;
use JetBrains\PhpStorm\Pure;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
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
            try {
                $user = $this->getUser();
                if ($user === null) {
                    throw new DomainException('You must be logged in');
                }
                $this->articleService->savePost($body['title'], $body['text'], $user->getId());
            } catch (DomainException $domainException) {
                return $this->render('danger-message', ['message' => $domainException->getMessage()]);
            }
            return $this->render('success-message', ['message' => 'Article created!']);
        }
        return $this->render('blog/create-article');
    }
}