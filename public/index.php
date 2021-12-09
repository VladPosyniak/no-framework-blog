<?php

use App\controller\ArticlePageController;
use App\controller\CreateArticlePageController;
use App\controller\DeleteArticlePageController;
use App\controller\LoginUserController;
use App\controller\MainPageController;
use App\controller\RegisterUserController;
use DI\ContainerBuilder;
use FastRoute\RouteCollector;
use Middlewares\FastRoute;
use Middlewares\RequestHandler;
use Relay\Relay;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;
use function FastRoute\simpleDispatcher;

require_once dirname(__DIR__) . '/config/env.php';
require_once dirname(__DIR__) . '/vendor/autoload.php';


$containerBuilder = new ContainerBuilder();
$containerBuilder->useAnnotations(false);
$containerBuilder->addDefinitions(require CONFIG_PATH . '/definitions.php');
$container = $containerBuilder->build();

$middlewareQueue[] = new FastRoute(simpleDispatcher(function (RouteCollector $routeCollector) {
    $routeCollector->get('/', MainPageController::class);
    $routeCollector->get('/article', ArticlePageController::class);
    $routeCollector->get('/create-article', CreateArticlePageController::class);
    $routeCollector->post('/create-article', CreateArticlePageController::class);
    $routeCollector->get('/delete-article', DeleteArticlePageController::class);
    $routeCollector->get('/registration', RegisterUserController::class);
    $routeCollector->post('/registration', RegisterUserController::class);
    $routeCollector->get('/login', LoginUserController::class);
    $routeCollector->post('/login', LoginUserController::class);
}));
$middlewareQueue[] = new RequestHandler($container);

$GLOBALS['container'] = $container;

$requestHandler = new Relay($middlewareQueue);
$response = $requestHandler->handle($container->get(ServerRequest::class));

$emitter = new Response\SapiEmitter();
$emitter->emit($response);