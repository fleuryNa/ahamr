<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->group('infrastructure', ['namespace' => 'Modules\Infrastructure\Controllers'], function ($routes) {
    $routes->get('/', 'Infrastructure::index');
});
