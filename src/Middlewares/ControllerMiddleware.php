<?php
 
namespace App\Middlewares;
use Middlewares\Utils\RequestHandlerContainer;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Middlewares\Utils\CallableHandler;
use Psr\Http\Server\RequestHandlerInterface;
 use Equip\Dispatch\MiddlewareCollection;
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
            //return $requestHandler->process($request, $handler); 
            if (is_string($requestHandler)) {
                $requestHandler = $this->container->get($requestHandler);
            }
            if ($requestHandler instanceof MiddlewareInterface) {
                return $requestHandler->process($request, $handler);
            }

            //(new CallableHandler($requestHandler))->process($request, $handler);
            
        }, $middlewares);    
         
        return $handler->handle($request);
    }
}