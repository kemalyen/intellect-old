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
                $this->setContainer($route['handler']);
            }
        });
        return $routes;
    }

    private function setContainer($route)
    {
        list($controller, $method) = explode('@', $route);

        $this->container->set($route, 
                        function(ContainerInterface $c) use ($controller, $method) {
                            $class = new $controller($c->get('Response'));
                            return [$class, $method];
                        }
        );
    }
}
