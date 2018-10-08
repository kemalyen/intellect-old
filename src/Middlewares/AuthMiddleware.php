<?php

namespace App\Middlewares;

use App\Models\User;
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

        $token = $this->fetchToken($request);
        if ($token != null){
            $request = $request->withAttribute("token", $token);
            $user = new User(1, 'kemalyen@gmail.com');
            $request = $request->withAttribute("user", $user);
        }

        return $handler->handle($request);
    }

    private function fetchToken(ServerRequestInterface $request): string
    {
        $header = "";
        $message = "Using token from request header";
        $headers = $request->getHeader('Authorization');
        $header = isset($headers[0]) ? $headers[0] : "";
        if (preg_match("/Bearer\s+(.*)$/i", $header, $matches)) {
            return $matches[1];
        }

        return false;

        //throw new Exception("Token not found.");
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
