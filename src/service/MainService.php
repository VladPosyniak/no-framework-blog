<?php
namespace Src\service;

use Psr\Http\Message\ResponseInterface;

class MainService
{
    private ResponseInterface $response;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public function sayHello(): ResponseInterface
    {
        $response = $this->response->withHeader('Content-Type', 'text/html');
        $response->getBody()->write("<html><head></head><body>Hello, world!</body></html>");
        return $response;
    }
}