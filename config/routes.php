<?php

return [
    ['method' => 'GET', 'path'  => '/', 'handler' => 'App\Controllers\HomeController@say'],
    ['method' => 'GET', 'path'  => '/hit', 'handler' => 'App\Controllers\HomeController@hit', 'middlewares' => [\App\Middlewares\AuthMiddleware::class, \App\Middlewares\RoleMiddleware::class]],
    ['method' => 'GET', 'path'  => '/token', 'handler' => 'App\Controllers\HomeController@token'],
    ['method' => 'POST', 'path'  => '/hit', 'handler' => 'App\Controllers\HomeController@post_hit'],
    ['method' => 'GET', 'path'  => '/hello/{name}', 'handler' => 'App\Controllers\HomeController@hello'],
    ['method' => 'GET', 'path'  => '/permit', 'handler' => 'App\Controllers\AdminController@permit', 'middlewares' => [\App\Middlewares\RoleMiddleware::class, \App\Middlewares\AuthMiddleware::class, ]],
    ['method' => 'GET', 'path'  => '/index', 'handler' => 'App\Controllers\AdminController@index', 'middlewares' => ['App\Middlewares\AuthMiddleware', 'App\Middlewares\RoleMiddleware']],
]; 
