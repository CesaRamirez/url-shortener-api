<?php

$app->post('/', 'LinksController@store');
$app->get('/', 'LinksController@show');
$app->get('/stats', 'LinkStatsController@show');
