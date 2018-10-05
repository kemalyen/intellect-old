<?php

return [
    ['method' => 'GET', 'path'  => '/', 'handler' => 'App\Controllers\HomeController@say'],
    ['method' => 'GET', 'path'  => '/hit', 'handler' => 'App\Controllers\HomeController@hit'],
    ['method' => 'POST', 'path'  => '/hit', 'handler' => 'App\Controllers\HomeController@post_hit'],
    ['method' => 'GET', 'path'  => '/hello/{name}', 'handler' => 'App\Controllers\HomeController@hello'],
    ['method' => 'GET', 'path'  => '/permit', 'handler' => 'App\Controllers\AdminController@permit'],
    ['method' => 'GET', 'path'  => '/index', 'handler' => 'App\Controllers\AdminController@index'],
]; 
 