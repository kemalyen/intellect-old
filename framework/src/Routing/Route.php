<?php

namespace Intellect\Routing;

use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;
use Intellect\Container\Container;
use Psr\Container\ContainerInterface;

class Route
{
    protected $container;

    public function __construct(Container $container = null)
    {
        $this->container = $container;
    }

    public function addRoutes($route_list = [])
    {
        $routes = simpleDispatcher(function (RouteCollector $r) use ($route_list) {
            foreach ($route_list as $route) {
                $r->addRoute($route['method'], $route['path'], $route['handler']);
                $this->setRouteToContainer($route['handler'], ((isset($route['middlewares']) ? $route['middlewares'] : [])));
            }
        });
        return $routes;
    }

    private function setRouteToContainer($route, $middlewares = [])
    {
        list($controller, $method) = explode('@', $route);


        $this->container->set($route, 
                        function(ContainerInterface $c) use ($controller, $method, $middlewares) {
                            $class = new $controller($c->get('Response'));
                            $class->middleware($middlewares);
                            return [$class, $method];
                        }
        );
    }
}
