<?php
namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthCheck implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {

        $session = \Config\Services::session();

        if (!session()->get("logged_in")) {
            // Sauvegardez l'URL actuelle
            session()->set('redirect_url', current_url());
            // Redirigez vers la page d'authentification
            return redirect()->to('/rrr');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Pas d'action après
    }
}
