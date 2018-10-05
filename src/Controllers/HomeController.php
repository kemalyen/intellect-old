<?php
 
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request; 

class HomeController extends BaseController
{
    public function hello(Request $request): ResponseInterface
    {
        $response = $this->response->withHeader('Content-Type', 'text/html');
        $response->getBody()
            ->write("<html><head></head><body>Hello ". $request->getAttribute('name') ."!</body></html>");

        return $response;        
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
