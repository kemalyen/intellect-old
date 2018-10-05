<?php

namespace Intellect\Container;

use Psr\Container\ContainerInterface;
class Container implements ContainerInterface
{
    protected $container;
    protected $builder;

    public function __construct()
    {
        $builder = new \DI\ContainerBuilder();
        $builder->useAutowiring(true);
        $builder->useAnnotations(false);
        $this->builder = $builder;
    }

    public function addDefinitions($definations = [])
    {
        $this->builder->addDefinitions($definations);
    }

    public function build()
    {
        $this->container = $this->builder->build();
    }

    public function set($id, $value)
    {
        return $this->container->set($id, $value);
    }

    public function get($id)
    {
        return $this->container->get($id);
    }

    public function has($id)
    {
        return $this->container->has($id);
    }

}
