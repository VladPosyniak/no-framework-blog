<?php

namespace App\controller;

use JetBrains\PhpStorm\Pure;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use SmartyException;
use Src\service\UserService;
use DomainException;

class RegisterUserController extends AbstractController
{
    private UserService $userService;

    #[Pure]
    public function __construct(ServerRequestInterface $request, ResponseInterface $response, UserService $userService)
    {
        parent::__construct($request, $response);
        $this->userService = $userService;
    }

    /**
     * @return ResponseInterface
     * @throws SmartyException
     */
    public function index(): ResponseInterface
    {
        if ($this->request->getMethod() === 'POST') {
            $body = $this->request->getParsedBody();
            try {
                $userID = $this->userService->register($body['name'], $body['email'], $body['password']);
                setcookie('blog_user_id', $userID, time()+60*60*24*30, '/');
            } catch (DomainException $domainException) {
                return $this->render('danger-message', ['message' => $domainException->getMessage()]);
            }
            return $this->render('success-message', ['message' => 'Welcome!']);
        }
        return $this->render('user/registration');
    }
}