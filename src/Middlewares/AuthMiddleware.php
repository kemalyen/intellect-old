<?php

namespace App\Middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Middlewares\Utils\Traits\HasResponseFactory;

class AuthMiddleware implements MiddlewareInterface 
{
    use HasResponseFactory;
/*     public function attribute(string $attribute): self
    {
        $this->attribute = $attribute;

        return $this;
    } */

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        print_r($request->getAttribute('route'));
        return $handler->handle($request);
    } 

    /**
     * Set the handler reference on the request.
     *
     * @param mixed $handler
     */
    protected function setHandler(ServerRequestInterface $request, $handler): ServerRequestInterface
    {
        return $request->withAttribute($this->attribute, $handler);
    }    
}
