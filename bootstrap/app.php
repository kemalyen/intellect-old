<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';
$route_list = require_once(dirname(__DIR__) . '/config/routes.php');
use App\Middlewares\AuthMiddleware;
use App\Middlewares\RouteMiddleware;
use Middlewares\RequestHandler;
use Relay\Relay;
use Zend\Diactoros\Response\SapiEmitter;
use Zend\Diactoros\ServerRequestFactory;
use Intellect\Intellect\Application;

$app = new Application();
$app->run();

$route = $app->get('Route');
$router = $route->addRoutes($route_list);
$container = $app->get('Container');

$middlewareQueue = [];
$middlewareQueue[] = new AuthMiddleware();
$middlewareQueue[] = new RouteMiddleware($router);
$middlewareQueue[] = new RequestHandler($container);
$middlewareQueue[] = new AuthMiddleware();
$requestHandler = new Relay($middlewareQueue);
$response = $requestHandler->handle(ServerRequestFactory::fromGlobals());
$emitter = new SapiEmitter();
return $emitter->emit($response);
