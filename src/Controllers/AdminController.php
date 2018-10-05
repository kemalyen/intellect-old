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

    public function permit(): ResponseInterface
    {
        $response = $this->response->withHeader('Content-Type', 'text/html');
        $response->getBody()
            ->write("<html><head></head><body>Admin Permit!</body></html>");

        return $response;
    }

    public function index(): ResponseInterface
    {
        $response = $this->response->withHeader('Content-Type', 'text/html');
        $response->getBody()
            ->write("<html><head></head><body>Admin Index!</body></html>");

        return $response;
    }    

}
