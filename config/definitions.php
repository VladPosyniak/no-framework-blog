<?php
namespace Config;

use App\controller\ArticlePageController;
use App\controller\CreateArticlePageController;
use App\controller\DeleteArticlePageController;
use App\controller\LoginUserController;
use App\controller\MainPageController;
use App\controller\RegisterUserController;
use App\db\FileConnection;
use Src\repository\ArticleRepository;
use Src\repository\UserRepository;
use Src\service\ArticleService;
use Src\service\UserService;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\ServerRequestFactory;
use function DI\create;
use function DI\get;
use Zend\Diactoros\Response;


return [
    //Controllers
    MainPageController::class => create(MainPageController::class)->constructor(get(ServerRequest::class), get(Response::class), get(ArticleService::class), get(UserService::class)),
    CreateArticlePageController::class => create(CreateArticlePageController::class)->constructor(get(ServerRequest::class), get(Response::class), get(ArticleService::class)),
    ArticlePageController::class => create(ArticlePageController::class)->constructor(get(ServerRequest::class), get(Response::class), get(ArticleService::class)),
    DeleteArticlePageController::class => create(DeleteArticlePageController::class)->constructor(get(ServerRequest::class), get(Response::class), get(ArticleService::class)),
    RegisterUserController::class => create(RegisterUserController::class)->constructor(get(ServerRequest::class), get(Response::class), get(UserService::class)),
    LoginUserController::class => create(LoginUserController::class)->constructor(get(ServerRequest::class), get(Response::class), get(UserService::class)),

    //Services
    ArticleService::class => create(ArticleService::class)->constructor(get(ArticleRepository::class),  get(UserRepository::class)),
    UserService::class => create(UserService::class)->constructor(get(UserRepository::class)),

    //Repositories
    ArticleRepository::class => create(ArticleRepository::class)->constructor(get(FileConnection::class)),
    UserRepository::class => create(UserRepository::class)->constructor(get(FileConnection::class)),

    //App
    FileConnection::class => create(FileConnection::class)->constructor(FILE_DB_PATH),
    ServerRequest::class => ServerRequestFactory::fromGlobals(),
    Response::class => create(Response::class),
];