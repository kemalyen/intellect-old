<?php
 
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface;

class HomeController  extends BaseController
{
     private $response;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    } 

    public function say(): ResponseInterface
    {
        $response = $this->response->withHeader('Content-Type', 'text/html');
        $response->getBody()
            ->write("<html><head></head><body>Hello world!</body></html>");

        return $response;
    }

    public function hit(): ResponseInterface
    {
        $response = $this->response->withHeader('Content-Type', 'text/html');
        $response->getBody()
            ->write("<html><head></head><body>Hit the world!</body></html>");

        return $response;
    }    

}
