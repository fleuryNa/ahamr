<?php
namespace App\Controllers;

use App\Models\AhamrModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * instance of model object
     *
     * @var AhamrModel
     */
    protected $model;
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    protected $session;

    /**
     * @return void
     */

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        // Preload any models, libraries, etc, here.
        $this->model   = new AhamrModel();
        $this->session = \Config\Services::session();
        // E.g.: $this->session = \Config\Services::session();

    }
    /**
     * fonction qui formate les chiffres en francais
     *
     * @param mixed $nombre
     * @param integer $decimal
     * @return mixed
     */
    public function formatNumber(mixed $nombre, int $decimal = 0): mixed
    {
        return number_format($nombre, $decimal, ',', ' ');
    }
/**
 * Fonction pour tronquer le texte
 */
    public function truncateText($text, $length)
    {
        if (strlen($text) > $length) {
            return substr($text, 0, $length) . '...';
        }
        return $text;
    }
    public function hasRole($requiredRole)
    {
        $roles = session()->get('role') ?? [];
        return in_array($requiredRole, $roles);
    }

}
