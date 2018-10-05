<?php

namespace App\Controllers;
use Psr\Http\Message\ResponseInterface;
abstract class BaseController
{
    public $response;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public function callAction($method, $parameters)
    {
        return call_user_func_array([$this, $method], $parameters);
    }

    /**
     * Handle calls to missing methods on the controller.
     *
     * @param  string  $method
     * @param  array   $parameters
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
