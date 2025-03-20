<?php

namespace App\Controllers;

use App\Services\UsersService;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Uru\SlimApiController\ApiController;
use App\Services\UsersServiceInterface;

class BaseController extends ApiController
{
    private UsersServiceInterface $usersService;

    public function __construct(UsersServiceInterface $usersService)
    {
        $this->usersService = $usersService;
    }

    public function index(Response $response): Response
    {
        $response->getBody()->write('<a href="/user/1">User info</a>');

        return $response->withStatus(200);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getUser(int $id, Request $request, Response $response): Response
    {
        $user = $this->usersService->createUser($id)->getUser();

        return $this->withJson($request, $response, [
            'id' => $user->getId(),
            'name' => $user->getName(),
        ])->withStatus(200);
    }
}
