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
