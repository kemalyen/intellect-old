<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface;


use ReallySimpleJWT\TokenBuilder;
use ReallySimpleJWT\Token;
use ReallySimpleJWT\TokenValidator;
abstract class BaseController
{
    public $response;

    protected $token;

    protected $middleware = [];

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public function getToken($payload = [])
    {
        $expiration = strtotime("+1 week");
        $builder = new TokenBuilder();
        $secret = "KMLynlmz@905339200362";
        $token = $builder->addPayload(['key' => 'foo', 'value' => 'bar'])
            ->setSecret($secret)
            ->setExpiration($expiration)
            ->setIssuer("issuer")
            ->build();
        return $this->token = $token;        
    }

    private function setToken(string $token)
    {
        $this->token = $token;
    }
 
    public function dispatch()
    {
        //var_dump($this->getMiddleware());
         
        return;
    }


    public function middleware($middleware, array $options = [])
    {
        foreach ((array)$middleware as $m) {
            $this->middleware[] = [
                'middleware' => $m,
                'options' => &$options,
            ];
        }
    }

    public function getMiddleware()
    {
        return $this->middleware;
    }

    public function callAction($method, $parameters)
    {
        return call_user_func_array([$this, $method], $parameters);
    }

    /**
     * Handle calls to missing methods on the controller.
     *
     * @param  string $method
     * @param  array $parameters
     * @return mixed
     *
     * @throws \BadMethodCallException
     */
    public function __call($method, $parameters)
    {
        throw new Exception(sprintf(
            'Method %s::%s does not exist.', static::class, $method
        ));
    }
}
