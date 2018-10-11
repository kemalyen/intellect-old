<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';
$route_list = require_once(dirname(__DIR__) . '/config/routes.php');
use App\Middlewares\AuthMiddleware;
use App\Middlewares\NestedMiddleware;
use App\Middlewares\RouteMiddleware;
use Middlewares\RequestHandler;
use Relay\Relay;
use Zend\Diactoros\Response\SapiEmitter;
use Zend\Diactoros\ServerRequestFactory;
use Intellect\Intellect\Application;
use Procurios\Http\MiddlewareDispatcher\Dispatcher;
use Equip\Dispatch\MiddlewareCollection;
use App\Middlewares\RoleMiddleware;
use App\Middlewares\ControllerMiddleware;
 
$app = new Application();
$app->run();

$route = $app->get('Route');
$router = $route->addRoutes($route_list);

$container = $app->get('Container');

$request = ServerRequestFactory::fromGlobals();
 
$middlewareQueue = [
    new RouteMiddleware($router),
    new ControllerMiddleware($container),
    new RequestHandler($container)
];
   
$collection = new MiddlewareCollection($middlewareQueue);
 
$default = function (ServerRequestInterface $request) {
    // Any implementation of PSR-7 ResponseInterface
    return new Response();
}; 
$response = $collection->dispatch($request, $default);

$emitter = new SapiEmitter();
return $emitter->emit($response);
