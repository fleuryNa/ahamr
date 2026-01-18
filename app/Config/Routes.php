<?php

use CodeIgniter\Router\RouteCollection;

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

$routes->group('cron', function ($routes) {
    $routes->get('checkAmortissement', 'Immobilisation::checkAmortissement'); //define as a cron job to run one a year
    $routes->get('changeetatchambre', 'Chambre::changeEtatChambreAuto');      //define as a cron job to run day  aday
});
/**
 * Gestion dashboard
 */
$routes->group('dashboard', ['filter' => 'checkLogin'], function ($routes) {
    $routes->get('/', 'DashboardGeneral::index');
    $routes->get('synthese', 'DashboardSynthese::index');
    $routes->get('sstock', 'DashboardSynthese::indexStock');
    $routes->get('getAnnualData/(:num)', 'DashboardSynthese::getAnnualData/$1');
    $routes->get('getAnnualDataStock/(:num)', 'DashboardSynthese::getAnnualDataStock/$1');
    $routes->get('comparaison', 'RapportComparatif::rapportAchatsVentes');
    $routes->match(['get', 'post'], 'frequenceachat', 'RapportFrequenceAchatConsomable::rapportFrequenceAchats');

});

/**
 * Gestion chambre
 */
$routes->group('chambre', ['filter' => 'checkLogin'], function ($routes) {
    $routes->get('/', 'Chambre::index');
    $routes->post('liste', 'Chambre::liste');
    $routes->post('reservation', 'Chambre::createReservation');
    $routes->get('etat', 'Chambre::getChambreStatut');
    $routes->post('changetat', 'Chambre::changeEtatChambre');
});
/**
 * Gestion stock
 */
$routes->group('stock', ['filter' => 'checkLogin'], function ($routes) {
    $routes->get('/', 'Stock::index');
    $routes->get('add', 'Stock::add');
    $routes->post('liste', 'Stock::liste');
    $routes->post('removetocarte', 'Stock::removeToCart');
    $routes->post('removetocarteS', 'Stock::removeToCartSortie');
    $routes->post('addtocart', 'Stock::addToCart');
    $routes->post('addtocartS', 'Stock::addToCartSortie');
    $routes->post('create', 'Stock::create');
    $routes->post('createMateriau', 'Stock::createMateriau');
    $routes->post('createUnite', 'Stock::createUnite');
    $routes->post('createQualite', 'Stock::createQualite');
    $routes->get('sortie', 'Stock::stockSortie');
    $routes->post('details', 'Stock::getStockDetail');

    $routes->post('cartsortie', 'Stock::getStockCartSortie');
    $routes->post('enregistrsortie', 'Stock::enregistrerSortie');
    $routes->post('listesortie', 'Stock::listeStockSortie');
//Declassement
    $routes->post('detailsd', 'Stock::getStockDetail');

    $routes->get('declassement', 'StockDeclassement::stockSortie');
    $routes->post('removetocarteSd', 'StockDeclassement::removeToCartSortie');
    $routes->post('addtocartSd', 'StockDeclassement::addToCartSortie');
    $routes->post('cartsortied', 'StockDeclassement::getStockCartSortie');
    $routes->post('enregistrsortied', 'StockDeclassement::enregistrerSortie');
    $routes->post('listesortied', 'StockDeclassement::listeStockSortie');

    //consomable
    $routes->get('consomable', 'AchatConsomable::index');
    $routes->post('consomable-ajouter-achat', 'AchatConsomable::ajouterAchatConsomable');
    $routes->post('consomable-ajouter-type', 'AchatConsomable::ajouterTypeConsomable');
    $routes->post('consomable-liste', 'AchatConsomable::listeAchatConsomable');
    $routes->get('consomable-get-types', 'AchatConsomable::getTypesConsomable');

    $routes->get('exporter-excel', 'Stock::exporterInvantaireStock');
    $routes->post('annuler-sortie', 'Stock::annulerSortie');
    $routes->post('annuler-entres', 'Stock::annulerEntree');
    $routes->post('annuler-sortied', 'StockDeclassement::annulerSortie');

});

/**
 * Gestion depense
 */
$routes->group('depense', ['filter' => 'checkLogin'], function ($routes) {
    $routes->get('/', 'Depense::index');
    $routes->post('create', 'Depense::createDepense');
    $routes->match(['get', 'post'], 'liste', 'Depense::listeDepense');
    $routes->post('createCategorie', 'Depense::createCategorie');

});

/**
 * Gestion VERSEMENT
 */
$routes->group('versement', ['filter' => 'checkLogin'], function ($routes) {
    $routes->get('/', 'Versement::index');
    $routes->post('create', 'Versement::createversement');
    $routes->post('annuler-versement', 'Versement::annulerVersement');
    $routes->match(['get', 'post'], 'liste', 'Versement::listeVersement');
    $routes->get('view/(:num)', 'Versement::view/$1');

});

/**
 * Gestion vente
 */
$routes->group('vente', ['filter' => 'checkLogin'], function ($routes) {
    $routes->get('ventenonfacture', 'Vente::index');
    $routes->post('details', 'Vente::getStockDetail');
    $routes->post('addtocartS', 'Vente::addToCartSortie');
    $routes->post('removetocarteS', 'Vente::removeToCartSortie');
    $routes->post('createvente', 'Vente::enregistrerVente');
    $routes->match(['get', 'post'], 'listevnf', 'Vente::getAllVente');
    $routes->get('facture/(:segment)', 'Vente::getFacture/$1');
    $routes->get('voirfacture/(:segment)', 'VenteUploader::detailFacture/$1');
    $routes->post('create', 'Depense::createDepense');

    $routes->get('/', 'VenteUploader::index');
    $routes->match(['get', 'post'], 'liste', 'VenteUploader::getAllVente');
    // Dans app/Config/Routes.php
    $routes->get('factures/det/(:num)', 'VenteUploader::getDetail/$1');

    // menu

    $routes->get('menu', 'Menu::index');
    $routes->post('ajoutermenu', 'Menu::createMenu');
    $routes->post('listemenu', 'Menu::getAllItems');
    $routes->post('getmenu', 'Menu::getOneMenu');
    $routes->get('export-menu', 'Menu::exportMenuToPdf');

    //Catégorie menu categmenu
    $routes->get('categmenu', 'Menu::categorieMenuIndex');
    $routes->post('ajoutercategmenu', 'Menu::createCategorieMenu');
    $routes->post('listecategmenu', 'Menu::getAllCategories');

    //Autre Source Revenu

    $routes->get('service', 'SourceRevenuAutre::index');
    $routes->post('servicecreate', 'SourceRevenuAutre::createRevenu');
    $routes->post('listerevenu', 'SourceRevenuAutre::listeSourceRevenu');
    $routes->get('sfacture/(:segment)', 'SourceRevenuAutre::getFacture/$1');

    //facture Proformat
    $routes->get('proformat', 'FactureProformat::index');
    $routes->post('fprocreate', 'FactureProformat::createFacturePro');
    $routes->post('fproliste', 'FactureProformat::listeFacturesProforma');
    $routes->delete('delFpro/(:segment)', 'FactureProformat::supprimerFacturesProforma/$1');
    $routes->get('voirfpro/(:segment)', 'FactureProformat::voirFacturesProforma/$1');
    $routes->get('printfpro/(:segment)', 'FactureProformat::imprimerFactureProformat/$1');

});

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

/**
 * Gestion parametrage
 */
$routes->group('parametrage', ['filter' => 'checkLogin'], function ($routes) {
    $routes->get('pchambre', 'Chambre::chambreIndex');
    $routes->post('chambreprice', 'Chambre::chambreChangePrix');
    //article
    $routes->get('article', 'Article::index');
    $routes->post('addarticle', 'Article::createArticle');
    $routes->post('listarticle', 'Article::getAllArticle');
    //Service
    $routes->get('service', 'Service::index');
    $routes->post('addservice', 'Service::createService');
    $routes->post('listservice', 'Service::getAllService');

});
/**
 * Gestion import factures OBR
 */
$routes->group('obr', ['filter' => 'checkLogin'], function ($routes) {
    $routes->get('facture', 'FactureImport::index');
    $routes->post('upload', 'FactureImport::uploadFacture');
    $routes->post('listefichier', 'FactureImport::listeFacture');

    //deductibles
    $routes->get('deductibles', 'DeductiveOBR::index');
    $routes->post('listedeductible', 'DeductiveOBR::listeDeductibles');
    $routes->post('listedettefourni', 'DeductiveOBR::listeDetteFournisseur');
    $routes->post('createdeductible', 'DeductiveOBR::createDeductible');
    $routes->post('updateStatutPaiement', 'DeductiveOBR::updateStatutPaiement');
    $routes->get('getdeductible/(:segment)', 'DeductiveOBR::getDeductible/$1');
    $routes->post('createfournisseur', 'DeductiveOBR::createFournisseur');
    $routes->post('deletededictible/(:segment)', 'DeductiveOBR::deleteDeductible/$1');

});

/**
 * Gestion rh
 */
$routes->group('rh', ['filter' => 'checkLogin'], function ($routes) {
    $routes->get('employe', 'Employe::index');
    $routes->post('liste', 'Employe::listeEmployer');
    $routes->post('createemploye', 'Employe::createEmployer');
    $routes->get('getemploye/(:segment)', 'Employe::getemploye/$1');
    //credits
    $routes->get('engagement', 'Credit::index');
    $routes->post('cliste', 'Credit::listeCredit');
    $routes->post('createcredit', 'Credit::createCredit');
    $routes->get('getcredit/(:segment)', 'Credit::getCredit/$1');

    //Deductions
    $routes->get('deduction', 'Deduction::index');
    $routes->post('dliste', 'Deduction::listeDeduction');
    $routes->post('creatededuction', 'Deduction::createDeduction');
    $routes->get('getdeduction/(:segment)', 'Deduction::getDeduction/$1');

    //Primes
    $routes->get('prime', 'Prime::index');
    $routes->get('primeaffectation', 'AffectationPrime::index');
    $routes->post('pliste', 'Prime::listePrime');
    $routes->post('apliste', 'AffectationPrime::listePrime');
    $routes->post('createprime', 'Prime::createPrime');
    $routes->post('createaprime', 'AffectationPrime::createPrime');
    $routes->get('getprime/(:segment)', 'Prime::getPrime/$1');
    $routes->get('getaprime/(:segment)', 'AffectationPrime::getPrime/$1');

    //Bulletins
    $routes->get('paie', 'Bulletin::index');
    $routes->get('listepaie/(:segment)', 'Bulletin::exportSalaire/$1');
    $routes->post('bliste', 'Bulletin::listeBulletin');
    $routes->get('createbulletin/(:segment)', 'Bulletin::calculPaie/$1');
    $routes->get('getbulletin/(:segment)', 'Prime::getBulletin/$1');
    $routes->get('bulletinpaie/(:num)/(:num)', 'Bulletin::genererPdf/$1/$2');
    $routes->get('getRetourTravail', 'Bulletin::getRetourTravail');
    $routes->post('addsanction', 'Bulletin::addSanction');

});
/**
 * Gestion route Invantaire
 */
$routes->group('invantaire', ['filter' => 'checkLogin'], function ($routes) {
    $routes->get('immobilisation', 'Immobilisation::index');
    $routes->post('liste', 'Immobilisation::listeImmobilisation');
    $routes->post('createimmob', 'Immobilisation::createImmobilisation');
    $routes->post('saveop', 'Immobilisation::saveOperation');
    $routes->get('getimmob/(:segment)', 'Immobilisation::getOneImmobilisation/$1');
    $routes->get('getplanAmmortissement/(:segment)', 'Immobilisation::planAmortissement/$1');

    $routes->get('localite', 'Localisation::index');
    $routes->post('addlocalite', 'Localisation::createLocalite');
    $routes->post('listlocalite', 'Localisation::getAllLocalite');
    //categimmo
    $routes->get('categimmo', 'CategorieImmobilisation::index');
    $routes->post('addcategimmo', 'CategorieImmobilisation::createCategorie');
    $routes->post('listcategimmo', 'CategorieImmobilisation::getAllCategorie');

    //Bouteille
    $routes->get('vides', 'StockBouteille::index');
    $routes->post('listbouteille', 'StockBouteille::listeMvt');
    $routes->post('addmvtbouteille', 'StockBouteille::createBouteille');

    $routes->get('exporter-excel', 'Immobilisation::exporterInvantaire');

});
$routes->group('dette', ['filter' => 'checkLogin'], function ($routes) {
    $routes->get('/', 'DetteManagment::index');
    $routes->post('liste', 'DetteManagment::listeDette');

    $routes->get('getalldette', 'DetteManagment::tableDettes');
    $routes->get('getonedet/(:segment)', 'DetteManagment::getDette/$1');

    $routes->post('createdette', 'DetteManagment::createRemboursement');

    $routes->post('saveop', 'Immobilisation::saveOperation');
    $routes->get('getimmob/(:segment)', 'Immobilisation::getDette/$1');
    $routes->get('getplanAmmortissement/(:segment)', 'Immobilisation::planAmortissement/$1');

});

$routes->group('rapport', function ($routes) {
    $routes->get('ventes', 'RapportVente::index');
    $routes->get('get-ventes-resto', 'RapportVente::getVentesResto');
    $routes->get('get-ventes-chambre', 'RapportVente::getVentesChambre');
    $routes->get('get-details-vente', 'RapportVente::getDetailsVente');
    $routes->get('etatstock', 'RapportVente::etatStock');
    $routes->get('getetatstock', 'RapportVente::getEtatStock');
    $routes->get('revenu-depense', 'RapportVente::tableRevenuDepense');
    $routes->get('syntheserd', 'RapportVente::RevenuDepence');
    $routes->get('tableDepensesParDate', 'RapportVente::tableDepensesParDate');
    $routes->get('control', 'RapportGeneral::index');
    $routes->get('chambre', 'RapportGeneral::tableauOccupation');
    $routes->get('revenuventechambre', 'RapportGeneral::revenuParPaiement');
});
