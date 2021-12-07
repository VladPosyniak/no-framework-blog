<?php
namespace App\controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Smarty;
use SmartyException;

abstract class AbstractController
{
    protected ServerRequestInterface $request;
    protected ResponseInterface $response;

    public function __construct(ServerRequestInterface $request, ResponseInterface $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    abstract public function index(): ResponseInterface;

    public function __invoke(): ResponseInterface
    {
        return $this->index();
    }

    /**
     * @throws SmartyException
     */
    protected function render(string $template, array $data = [], $layout = 'layout'): ResponseInterface
    {
        $smarty = new Smarty();
        $smarty->setTemplateDir(VIEWS_PATH . '/');
        $smarty->setCacheDir(RESOURCES_PATH);
        $smarty->assign('data', $data);
        $smarty->assign('template', $template . '.tpl');
        if ($userID = $this->getUserID()) {
            $smarty->assign('userID', $userID);
        }
        $response = $this->response->withHeader('Content-Type', 'text/html');
        $response->getBody()->write($smarty->fetch($layout . '.tpl'));
        return $response;
    }

    protected function getUserID(): ?string
    {
        return $this->request->getCookieParams()['blog_user_id'] ?? null;
    }
}