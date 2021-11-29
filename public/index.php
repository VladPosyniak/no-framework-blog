<?php

use App\controller\MainController;
use DI\ContainerBuilder;
use FastRoute\RouteCollector;
use Middlewares\FastRoute;
use Middlewares\RequestHandler;
use Relay\Relay;
use Src\service\MainService;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequestFactory;

use function DI\create;
use function DI\get;
use function FastRoute\simpleDispatcher;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$containerBuilder = new ContainerBuilder();
$containerBuilder->useAutowiring(false);
$containerBuilder->useAnnotations(false);
$containerBuilder->addDefinitions([
                                      MainService::class => create(MainService::class)->constructor(get('response')),
                                      MainController::class => create(MainController::class)->constructor(get(MainService::class)),
                                      'response' => create(Response::class)
                                  ]);

$container = $containerBuilder->build();

$routes = simpleDispatcher(function (RouteCollector $routeCollector) {
    $routeCollector->get('/hello', MainController::class);
});

$middlewareQueue[] = new FastRoute($routes);
$middlewareQueue[] = new RequestHandler($container);

$requestHandler = new Relay($middlewareQueue);
$response = $requestHandler->handle(ServerRequestFactory::fromGlobals());

$emitter = new Response\SapiEmitter();
$emitter->emit($response);