<?php
 
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request; 
use ReallySimpleJWT\TokenBuilder;
use ReallySimpleJWT\Token;
use ReallySimpleJWT\TokenValidator;
class HomeController extends BaseController
{
    public function hello(Request $request): ResponseInterface
    {
        $user = $request->getAttribute('user');

        $response = $this->response->withHeader('Content-Type', 'text/html');
        $response->getBody()
            ->write("<html><head></head><body>Hello ". $request->getAttribute('name') . " -". $user->getEmail() ."!</body></html>");

        return $response;        
    }

    public function say(): ResponseInterface
    {
        $token = $this->getToken();
        $this->token = $token;
        $token1 = $this->token;
        $response = $this->response->withHeader('Content-Type', 'text/html');
        $response->getBody()
            ->write("<html><head></head><body>Hello world!." . $token1 . ".</body></html>");

        return $response;
    }

    public function token(): ResponseInterface
    {
        $expiration = strtotime("tomorrow");
        $builder = new TokenBuilder();
        $secret = "KMLynlmz@905339200362";
        $token = $builder->addPayload(['key' => 'user_id', 'value' => 1])
            ->setSecret($secret)
            ->setExpiration($expiration)
            ->setIssuer("issuer")
            ->build();
        
            //$result = Token::validate($token, $secret);

            $validator = new TokenValidator;

            $validator->splitToken($token)
                ->validateExpiration()
                ->validateSignature($secret);
            
            $payload = $validator->getPayload();
            $decoded = json_decode($payload);
            var_dump($decoded->user_id);
            die();
            $header = $validator->getHeader();            

        $response = $this->response->withHeader('Content-Type', 'text/html');
        $response->getBody()
            ->write("<html><head></head><body>". $token . '<br/>'. $payload. '<br/>'. $header . "</body></html>");

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
