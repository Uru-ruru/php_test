<?php

use App\Services\CollectionUsersServiceInterface;
use App\Services\CollectionUsersService;
use App\Services\UsersServiceInterface;
use App\Controllers\BaseController;
use App\Controllers\UsersController;
use App\Middleware\KeyMiddleware;
use App\Services\UsersService;
use App\Http\JsonResponse;
use DI\Bridge\Slim\Bridge;
use Dotenv\Dotenv;

require __DIR__.'/../vendor/autoload.php';
$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$builder = new \DI\ContainerBuilder();
$builder->addDefinitions([
    CollectionUsersServiceInterface::class => \DI\create(CollectionUsersService::class),
    UsersServiceInterface::class => \DI\create(UsersService::class),
    KeyMiddleware::class => \DI\create()->constructor(\DI\get(JsonResponse::class), \DI\get('key')),
    'key' => $_ENV['KEY'],
]);
$container = $builder->build();

$app = Bridge::create($container);

$app->addErrorMiddleware(true, true, true);

$app->get('/', [BaseController::class, 'index']);

$app->get('/users/last/', [UsersController::class, 'getLastUser']);

$app->get('/user/{id}', [UsersController::class, 'getUser']);

$app->get('/users/', [UsersController::class, 'getAllUsers'])
    ->add($container->get(KeyMiddleware::class));

$app->run();
