<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface;

use League\Fractal;
use League\Fractal\Serializer\JsonApiSerializer;
use League\Fractal\Manager;
use Psr\Http\Message\ServerRequestInterface as Request;
 
class AdminController extends BaseController
{
    public function permit(): ResponseInterface
    {
        $book = new \stdClass();
        $book->id = 1;
        $book->title = 'Deneme';

        $resource = new Fractal\Resource\Item($book, function ($book) {
            return [
                'id' => (int)$book->id,
                'title' => $book->title,

            ];
        });
        $manager = new Manager();
        $manager->setSerializer(new JsonApiSerializer());
        $result = $manager->createData($resource)->toJson();
        $response = $this->response->withHeader('Content-Type', 'application/json');
        $response->getBody()
            ->write($result);

        return $response;
    }

    public function index(Request $request): ResponseInterface
    {
        $user = $request->getAttribute('user');
        var_dump($user);
        $response = $this->response->withHeader('Content-Type', 'text/html');
        $response->getBody()
            ->write("<html><head></head><body>Admin Index!". "." ."</body></html>");

        return $response;
    }

}
