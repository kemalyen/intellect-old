<?php
 
namespace App\Middlewares;
use Middlewares\Utils\RequestHandlerContainer;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
class ControllerMiddleware implements MiddlewareInterface
{
 
    /**
     * @var ContainerInterface Used to resolve the handlers
     */
    private $container;
    /**
     * @var string Attribute name for handler reference
     */
    private $handlerAttribute = 'request-handler';
    
    public function __construct(ContainerInterface $container = null)
    {
        $this->container = $container ?: new RequestHandlerContainer();
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    { 
        $requestHandler = $request->getAttribute($this->handlerAttribute);
        if (is_string($requestHandler)) {
            $middlewares = $this->container->get($requestHandler.".middlewares");
        }
 
        array_map( function($requestHandler) use ($request, $handler)
        {
            return (new $requestHandler)->process($request, $handler);
        
        }, $middlewares); 
 
         
        return $handler->handle($request);
    }
  
}