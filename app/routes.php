<?php

declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use App\Samu\Routes;
use App\Samu\Product;
use App\Samu\Chapter;

return function (App $app) {

    $app->get('/', function (Request $request, Response $response) {
        $response->withHeader('Content-Type', 'application/json');
        $response->getBody()->write('Hello world!');
        return $response;
    });

    Routes::proccess('/product', Product::model(), $app);
    Routes::proccess('/chapter', Chapter::model(), $app);
};
