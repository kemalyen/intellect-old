<?php

namespace App\Middlewares;

use Psr\Container\ContainerInterface;
use Middlewares\Utils\RequestHandlerContainer;
use Zend\Diactoros\ServerRequestFactory;
use Intellect\Container\Container;

class NestedMiddleware
{
    /**
     * @var ContainerInterface Used to resolve the handlers
     */
    private $container;
    /**
     * @var string Attribute name for handler reference
     */
    private $handlerAttribute = 'request-handler';    

    public function __construct(Container $container = null)
    {
        $this->container = $container ?: new RequestHandlerContainer();
    }

    public function getNestedMiddlewares()
    {
        $middlewares = [];
        $route = $this->container->get('router');

        if (is_string($route)) {
            $middlewares = $this->container->get($route.".middlewares");
        }
//        var_dump($middlewares);
        return $middlewares;
    }
}