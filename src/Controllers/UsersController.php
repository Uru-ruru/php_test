<?php

namespace App\Controllers;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Services\CollectionUsersServiceInterface;
use Uru\SlimApiController\ApiController;
use App\Http\JsonResponse;
use Exception;

class UsersController extends ApiController
{
    private JsonResponse $jsonResponse;
    private CollectionUsersServiceInterface $collectionUsersService;

    public function __construct(
        JsonResponse $jsonResponse,
        CollectionUsersServiceInterface $collectionUsersService
    ) {
        $this->jsonResponse = $jsonResponse;
        $this->collectionUsersService = $collectionUsersService;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getAllUsers(Request $request, Response $response): Response
    {
        try {
            $users = $this->collectionUsersService->ListUsers();
            return $this->jsonResponse->withJson($users);
        } catch (Exception $e) {
            return $this->jsonResponse->withJson([$e->getMessage()], $e->getCode());
        }
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getLastUser(Request $request, Response $response): Response
    {
        $user = $this->collectionUsersService->ListUsers()->sortByDesc(fn($value) => $value['REG_DATE'])->first();
        return $this->jsonResponse->withJson($user);
    }


    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getUser(int $id, Request $request, Response $response): Response
    {
        $user = $this->collectionUsersService->ListUsers()->first(fn($value) => $value->id === $id);
        return $this->jsonResponse->withJson($user->fields);
    }
}