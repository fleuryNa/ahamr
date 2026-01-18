<?php
namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class CheckLogin implements FilterInterface
{

    /**
     * Check loggedIn to redirect page
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $routeName = $request->uri->getSegment(1); //requested route
        if (! session()->get("logged_in")) {
                                                           // code...
            session()->set('redirect_url', current_url()); //garder l'url actuelle pour lui retourner dessous apres la reconnexion
            return redirect()->route('logout');
        } else {
            $role = session()->get("role");
            if (! in_array($routeName, $role)) {
                // code...
                return redirect()->route('accessDeny');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
        $response->setHeader('X-Robots-Tag', 'noindex, nofollow');
    }
}
