<?php

namespace Intellect\Intellect;

use App\Controllers\BaseController;
use function DI\create;
use function DI\get;
use Zend\Diactoros\Response;
use Intellect\Container\Container;

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
            'Container' => $this->container,
            'Route' => create(\Intellect\Routing\Route::class)->constructor(get('Container')),
            'BaseController' => create(BaseController::class)->constructor(get('Response')),
            'Response' => function () {
                return new Response();
            },
            'Request' => function () {
                return new Request();
            },
        ]);
    }
 

    public function get($id)
    {
        return $this->container->get($id);
    }
}
