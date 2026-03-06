<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->group('infrastructure', ['namespace' => 'Modules\Infrastructure\Controllers', 'filter' => 'checkLogin'], function ($routes) {
    $routes->get('/', 'Infrastructure::index');
    $routes->post('liste_captage', 'Infrastructure::getInfraCaptage');
    $routes->post('liste_chambre', 'Infrastructure::getInfraChambre');
    $routes->post('liste_conduite', 'Infrastructure::getInfraConduite');
    $routes->post('liste_reservoir', 'Infrastructure::getInfraReservoir');
    $routes->post('liste_bf', 'Infrastructure::getInfraBf');
    $routes->post('get_commune_by_province', 'Infrastructure::getCommuneByProvince'); //get commune by province
    $routes->post('get_zone_by_commune', 'Infrastructure::getZoneByCommune');         //get zone by commune
    $routes->post('get_colline_by_zone', 'Infrastructure::getCollineByZone');         //get colline by zone
    $routes->post('get_aep_by_commune', 'Infrastructure::getAepByCommune');
    $routes->post('enregistrer_infra', 'Infrastructure::enregistrerInfra');
    $routes->post('get/(:num)', 'Infrastructure::getInfra/$1');

    //AEP
    $routes->get('aep', 'Aep::index');
    $routes->post('enregistrer_aep', 'Aep::enregistrerAep');
    $routes->post('getaep/(:num)', 'Aep::getAep/$1');
    $routes->post('liste_aep', 'Aep::getAepList');
    $routes->post('enregistrer_exploitant', 'Aep::enregistrerExploitant');
    $routes->post('get_exploitant/(:num)', 'Aep::getExploitant/$1');
    $routes->post('liste_exploitant', 'Aep::exploitantList');
    $routes->post('createTypeDocument', 'Aep::createTypeDocument');
    $routes->post('enregistrer_archive', 'Aep::enregistrerArchive');
    $routes->post('delete_archive/(:num)', 'Aep::deleteArchive/$1');
    $routes->get('download_archive/(:num)', 'Aep::downloadArchive/$1');
    $routes->post('liste_archives', 'Aep::archiveList');

    //Maintenance
    $routes->get('maintenance', 'Maintenance::index');
    $routes->post('liste_maintenance', 'Maintenance::getMaintenance');
    $routes->post('validerMdata', 'Maintenance::validerMaintenance');

    $routes->post('getDetailsMaintenance/(:num)', 'Maintenance::getMaintenanceById/$1');

});
