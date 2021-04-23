<?php

declare(strict_types=1);

namespace App\Samu;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

class Routes
{
    static public function proccess($url, $product,App $app)
    {
        
        $app->group($url , function (Group $group) use ($product, $url){
            $group->get('', function (Request $request, Response $response) use ($product, $url) {
                $out = $product->get();
                if (strlen($out) == 2) {
                    return self::out($out, $response, 404);
                }
                return self::out($product->get(), $response);
            });
            $group->get('/{id}', function (Request $request, Response $response, $param) use ($product) {
                $out = $product->get($param['id']);
                if (strlen($out) == 2) {
                    return self::out($out, $response, 404);
                }
                return self::out($out, $response, 302);
            });
            $group->post('', function (Request $request, Response $response, $param)  use ($product){
                $body = json_decode((string)$request->getBody()); //{"data": "adadad"}
                $out = $product->post($body);
                return self::out($out, $response, 201);
            });
            $group->patch('/{id}', function (Request $request, Response $response, $param)  use ($product){
                $body = json_decode((string)$request->getBody()); //{"data": "adadad"}
                return self::out($product->patch($param['id'], $body), $response);
            });
            $group->delete('/{id}', function (Request $request, Response $response, $param)  use ($product){
                return self::out($product->del($param['id']), $response);
            });
        });
    }
    static private function out($result, $response, $code = 200)
    {
        $response->withHeader('Content-Type', 'application/json');
        $response->getBody()->write($result);
        return $response->withStatus($code);
    }
}
