<?php

namespace App\Http;

use Slim\Psr7\Response;
use Illuminate\Support\Collection;

class JsonResponse extends Response
{
    public function withJson(null|array|Collection $data, int $status = 200): Response
    {
        if (empty($data)) {
            $status = 204;
        }

        $successData = [
            'success' => ($status === 200),
            'result' => $data,
        ];

        $payload = json_encode($successData);

        $this->getBody()->write($payload);

        return $this
            ->withHeader('Content-Type', 'application/json');
    }
}