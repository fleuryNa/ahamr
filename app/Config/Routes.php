<?php

use CodeIgniter\Router\RouteCollection;

if (is_file(APPPATH . 'Modules/Infrastructure/Config/Routes.php')) {
    require APPPATH . 'Modules/Infrastructure/Config/Routes.php';
}

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Login::index');
$routes->post('login', 'Login::doLogin');
$routes->get('logout', 'Login::doLogout');
$routes->get('checkSession', 'Login::checkSession');
$routes->get('createPassword/(:any)', 'Login::indexCP/$1');
$routes->post('savenewpassword', 'Login::createPassWord');
$routes->set404Override(function () {
    // code...
    return view('NotFoundView');
});
$routes->get('accessDeny', 'Login::accessDeny');

/**
 * Gestion admin
 */
$routes->group('admin', ['filter' => 'checkLogin'], function ($routes) {
    $routes->get('profil', 'Profil::index');
    $routes->post('listeprof', 'Profil::liste');
    $routes->post('addprofil', 'Profil::addProfil');
    $routes->post('getrole', 'Profil::getRole');
    $routes->get('role', 'Profil::role');
    $routes->get('users', 'SystemUser::index');
    $routes->post('listeuser', 'SystemUser::listeUser');
    $routes->post('createuser', 'SystemUser::addUser');
    $routes->post('resetPassword', 'SystemUser::resetPassword');
    $routes->post('toggleStatus', 'SystemUser::toggleStatus');

});

// routes du module SIG
$routes->group('sig', static function ($routes) {
    // Page carte (ta route existante - on ne touche pas)
    $routes->get('carte_infrastructure', '\App\Modules\sig\Controllers\CarteInfrastructures::index');

    //  Route API pour récupérer les points (Leaflet)
    $routes->get('carte_infrastructure/points', '\App\Modules\sig\Controllers\CarteInfrastructures::points');

    $routes->get('aep_map', '\App\Modules\sig\Controllers\CarteAep::index');
    $routes->get('aep_map/data', '\App\Modules\sig\Controllers\CarteAep::data');

    $routes->get('maintenance', '\App\Modules\sig\Controllers\CarteMaintenance::index');
    $routes->get('maintenance/data', '\App\Modules\sig\Controllers\CarteMaintenance::data');
});