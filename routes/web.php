<?php

$router->post('/', 'LinksController@store');
$router->get('/', 'LinksController@show');
$router->get('/stats', 'LinkStatsController@show');
