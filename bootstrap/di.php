<?php
 
use App\Controllers\HomeController;

use Psr\Container\ContainerInterface;

use function DI\create;
use function DI\get;
use function DI\factory;
use Zend\Diactoros\Response;

$containerBuilder = new \DI\ContainerBuilder();
$containerBuilder->useAutowiring(false);
$containerBuilder->useAnnotations(false);
$containerBuilder->addDefinitions(
    [
    'HomeController@say'  => function(ContainerInterface $c){
        $home = new HomeController($c->get('Response'));
        return [$home, 'say'];
    },
 
    'Response' => function () {
        return new Response();
    },
    'Request' => function () {
        return new Request();
    },    
]);

return $containerBuilder->build();