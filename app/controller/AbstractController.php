<?php
namespace App\controller;

use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Smarty;
use SmartyException;
use Src\entity\UserEntity;
use Src\repository\UserRepository;

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
        $smarty->assign('user', $this->getUser());
        $response = $this->response->withHeader('Content-Type', 'text/html');
        $response->getBody()->write($smarty->fetch($layout . '.tpl'));
        return $response;
    }

    protected function getUser(): ?UserEntity
    {
        if (isset($_COOKIE['blog_user_id'])) {
            /** @var UserRepository $userRepository */
            $userRepository = $GLOBALS['container']->get(UserRepository::class);
            try {
                return $userRepository->findOne($_COOKIE['blog_user_id']);
            } catch (Exception) {
                unset($_COOKIE['blog_user_id']);
                setcookie('blog_user_id', null, -1, '/');
                return null;
            }
        }

        return null;
    }
}