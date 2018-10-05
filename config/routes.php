<?php

return [
    ['method' => 'GET', 'path'  => '/', 'handler' => 'App\Controllers\HomeController@say'],
    ['method' => 'GET', 'path'  => '/hit', 'handler' => 'App\Controllers\HomeController@hit'],
    ['method' => 'POST', 'path'  => '/hit', 'handler' => 'App\Controllers\HomeController@post_hit'],
]; 
 