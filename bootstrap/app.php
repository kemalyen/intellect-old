<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use App\Middlewares\AuthMiddleware;
use App\Middlewares\RouteMiddleware;
use Middlewares\FastRoute;
use Middlewares\RequestHandler;

use Relay\Relay;
use Zend\Diactoros\Response\SapiEmitter;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response;
use Zend\Diactoros\Request;
use App\Controllers\HomeController;
use App\Controllers\Home;
use Psr\Container\ContainerInterface;

use Intellect\Routing\Route;


$route_list = require_once(dirname(__DIR__) . '/config/routes.php');


$container = require_once('di.php');


$route = new Route($container);
$router = $route->addRoutes($route_list);


$container->set('HomeController@hit', 
                        function(ContainerInterface $c){
                            $home = new HomeController($c->get('Response'));
                            return [$home, 'hit'];
                        }
    );

$middlewareQueue = [];
//$middlewareQueue[] = new AuthMiddleware();
$middlewareQueue[] = new RouteMiddleware($router);
$middlewareQueue[] = new RequestHandler($container);    
 
$requestHandler = new Relay($middlewareQueue);
$response = $requestHandler->handle(ServerRequestFactory::fromGlobals());
$emitter = new SapiEmitter();
return $emitter->emit($response);