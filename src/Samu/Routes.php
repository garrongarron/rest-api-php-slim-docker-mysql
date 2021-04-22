<?php

declare(strict_types=1);

namespace App\Samu;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use App\Samu\ProductSingleton;


class Routes
{
    static public function proccess(App $app)
    {
        $app->group('/product', function (Group $group) {
            $group->get('', function (Request $request, Response $response) {
                $product = ProductSingleton::getInstance();
                $out = $product->get();
                if (strlen($out) == 2) {
                    return self::out($out, $response, 404);
                }
                return self::out($product->get(), $response);
            });
            $group->get('/{id}', function (Request $request, Response $response, $param) {
                $product = ProductSingleton::getInstance();
                $out = $product->get($param['id']);
                if (strlen($out) == 2) {
                    return self::out($out, $response, 404);
                }
                return self::out($out, $response, 302);
            });
            $group->post('', function (Request $request, Response $response, $param) {
                $body = json_decode((string)$request->getBody()); //{"data": "adadad"}
                $product = ProductSingleton::getInstance();
                $out = $product->post($body->data);
                return self::out($out, $response, 201);
            });
            $group->patch('/{id}', function (Request $request, Response $response, $param) {
                $body = json_decode((string)$request->getBody()); //{"data": "adadad"}
                $product = ProductSingleton::getInstance();
                return self::out($product->patch($param['id'], $body->data), $response);
            });
            $group->delete('/{id}', function (Request $request, Response $response, $param) {
                $product = ProductSingleton::getInstance();
                return self::out($product->del($param['id']), $response);
            });
        });
    }
    static private function out($result, $response, $code = 200)
    {
        $response->getBody()->write($result);
        $response->withHeader('Content-Type', 'application/json');
        return $response->withStatus($code);
    }
}
