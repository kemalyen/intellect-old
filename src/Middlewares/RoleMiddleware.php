<?php

namespace App\Middlewares;

use App\Models\User;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Closure;
class RoleMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {  
         
        $user = new User(1, 'kemalyen@gmail.com');
        $request = $request->withAttribute("user", $user);
        return $handler->handle($request);
    }

    protected function setHandler(ServerRequestInterface $request, $handler): ServerRequestInterface
    {
        return $request->withAttribute($this->attribute, $handler);
    }    
}
