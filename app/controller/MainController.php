<?php
namespace App\controller;

use Psr\Http\Message\ResponseInterface;
use Src\service\MainService;

class MainController extends AbstractController
{
    private MainService $mainService;

    public function __construct(MainService $mainService)
    {
        $this->mainService = $mainService;
    }

    public function main(): void
    {
        $this->mainService->sayHello();
    }

    public function __invoke(): ResponseInterface
    {
        return $this->mainService->sayHello();
    }
}