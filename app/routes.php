<?php

declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use App\Samu\Routes;
use App\Samu\Modules\Body;
use App\Samu\Modules\Chapter;
use Slim\Exception\HttpNotFoundException;

return function (App $app) {
    $app->options(
        '/{routes:.+}',
        function ($request, $response, $args) {
            return $response;
        }
    );

    $app->add(function ($request, $handler) {
        $response = $handler->handle($request);
        return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader(
                'Access-Control-Allow-Headers',
                'X-Requested-With, Content-Type, Accept, Origin, Authorization'
            )
            ->withHeader(
                'Access-Control-Allow-Methods',
                'GET, POST, PUT, DELETE, PATCH, OPTIONS'
            );
    });
    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');
        return $response;
    });

    Routes::proccess('/header', Chapter::model(), $app);
    Routes::proccess('/body', Body::model(), $app);


    $app->map(
        ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'],
        '/{routes:.+}',
        function ($request, $response) {
            throw new HttpNotFoundException($request);
        }
    );
};
