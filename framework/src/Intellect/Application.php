<?php

namespace Intellect\Intellect;

use App\Controllers\BaseController;
use function DI\create;
use function DI\get;
use Zend\Diactoros\Response;
 
use Intellect\Container\Container;

use Psr\Http\Server\RequestHandlerInterface as Request;
class Application
{
    protected $container;

    public function __construct($basePath = null)
    {
        $this->container = new Container();
        $this->addDefinationsContainer();
    }

    public function run()
    {
        $this->container->build();
 
    }

    private function addDefinationsContainer()
    {
        $this->container->addDefinitions([
            'router'    => null,
            'Container' => $this->container,
            'Route' => create(\Intellect\Routing\Route::class)->constructor(get('Container')),
            'BaseController' => create(BaseController::class)->constructor(get('Response')),
            'Response' => function () {
                return new Response();
            },
            'Authenticate'    => create(\Intellect\Auth\Authenticate::class),
            
        ]);
    }
 
    public function get($id)
    {
        return $this->container->get($id);
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $route = $this->router->dispatch($request->getMethod(), $request->getUri()->getPath());

        if ($route[0] === Dispatcher::NOT_FOUND) {
            return $this->createResponse(404);
        }

        if ($route[0] === Dispatcher::METHOD_NOT_ALLOWED) {
            return $this->createResponse(405)->withHeader('Allow', implode(', ', $route[1]));
        }

        foreach ($route[2] as $name => $value) {
            $request = $request->withAttribute($name, $value);
        }

 
        $request = $this->setHandler($request, $route[1]);
         
        return $handler->handle($request);
    }

}
