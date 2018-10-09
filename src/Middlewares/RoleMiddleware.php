<?php

namespace App\Middlewares;

use App\Models\User;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Middlewares\Utils\Traits\HasResponseFactory;

class RoleMiddleware implements MiddlewareInterface 
{
    use HasResponseFactory;

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        var_dump("rollll!");
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
