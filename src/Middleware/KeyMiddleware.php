<?php

namespace App\Middleware;

use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\MiddlewareInterface;
use App\Http\JsonResponse;

class KeyMiddleware implements MiddlewareInterface
{
    private JsonResponse $jsonResponse;
    private string $key;

    public function __construct(
        JsonResponse $jsonResponse,
        string $key
    ) {
        $this->jsonResponse = $jsonResponse;
        $this->key = $key;
    }

    public function process(Request $request, RequestHandler $handler): Response
    {
        $key = $request->getHeaderLine('X-api-key');

        if ($key !== $this->key) {
            return $this->jsonResponse->withJson(['Некорректный ключ'], 401);
        }

        return $handler->handle($request);
    }
}