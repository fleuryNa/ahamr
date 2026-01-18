<?php
namespace App\Controllers;

use App\Controllers\BaseController;

class Login extends BaseController
{
    public function index()
    {
        //

        return view('LoginView');
    }
    public function doLogin()
    {
        // code...
        $statutconnexion = false;
        $USERNAME        = $this->request->getPost('USERNAME');
        $PASSWORD        = sha1($this->request->getPost('PASSWORD'));
        $connexion       = $this->model->getRequeteOne('SELECT `USER_ID`,CREATE_PASSWORD, `MATRICULE`, `NOM`, `PRENOM`, `TEL`, `DATE_NAISSANCE`, `EMAIL`, `ID_SEXE`, `IS_ACTIVE`, rh_users.`ID_PROFIL`,rh_profil.PRO_DESCR,DATE_SYSTEME FROM `rh_users` JOIN rh_profil ON rh_users.ID_PROFIL=rh_profil.ID_PROFIL WHERE (`TEL` LIKE "' . $USERNAME . '" OR `EMAIL` LIKE "' . $USERNAME . '") AND `PASSWORD` LIKE "' . $PASSWORD . '" AND `IS_ACTIVE`=1;');
        if (empty($connexion)) {
            # code...
            return $this->response->setJSON([
                'success'  => $statutconnexion,
                'response' => "Mot de passe ou mot d'utilisateur incorrect",
            ]);
        }
        if ($connexion['CREATE_PASSWORD'] == 0) {
            //createPassword
            return $this->response->setJSON([
                'success'      => true,
                'response'     => "",
                'redirect_url' => 'createPassword/' . md5($connexion['USER_ID']),
            ]);

        }

        $sql      = "SELECT rh_role.ROUTE FROM `rh_role_profil`  JOIN rh_role ON rh_role_profil.ID_ROLE=rh_role.ID_ROLE  WHERE `ID_PROFIL`=" . $connexion['ID_PROFIL'];
        $datarole = $this->model->datatable($sql);
        $role     = [];
        foreach ($datarole as $key) {
            // code...
            $role[] = $key->ROUTE;
        }

        if (! empty($connexion['USER_ID'])) {
            $statutconnexion = true;
            $newdata         = [
                'userdata'  => $connexion,
                'role'      => $role,
                'logged_in' => true,
            ];
            $defaultroute = base_url('rapport/ventes');
            if (in_array('dashboard', $role)) {
                # code...
                $defaultroute = base_url('dashboard');

            }
            // Récupérez l'URL de redirection ou définissez une page par défaut
            $redirect_url = $this->session->get('redirect_url') ?? $defaultroute;
            $this->session->remove('redirect_url'); // Supprimez après redirection
            $this->session->set($newdata);
        }
        return $this->response->setJSON([
            'success'      => $statutconnexion,
            'response'     => "",
            'redirect_url' => $redirect_url,
        ]);
    }
    public function doLogout()
    {
        $this->session->remove('logged_in');
        $this->session->remove('userdata');
        $this->session->remove('role');
        // $this->session->destroy();
        return redirect()->route('/');
    }
    public function checkSession()
    {
        $userdata = session()->get("userdata");
        $userId   = $userdata['USER_ID'] ?? '';
        if (empty($userId)) {
            return $this->response->setJSON(['active' => false]);
        } else {
            return $this->response->setJSON(['active' => true]);
        }
    }
    public function accessDeny()
    {
        return view('AccessDenyView');
    }
    public function createPassWord()
    {
        $PASSWORD = sha1($this->request->getPost('PASSWORD'));
        $USER_ID  = $this->request->getPost('USER_ID');
        $this->model->updateData('rh_users', ['USER_ID' => $USER_ID], ['PASSWORD' => $PASSWORD, 'CREATE_PASSWORD' => 1]);
        return $this->response->setJSON([
            'success'      => 1,
            'response'     => "",
            'redirect_url' => base_url('/'),
        ]);
    }
    public function indexCP($USER_ID)
    {
        $connexion = $this->model->getRequeteOne("SELECT `USER_ID`,`NOM`,`PRENOM` FROM `rh_users` WHERE CREATE_PASSWORD=0 and md5(`USER_ID`)='" . $USER_ID . "'");
        $data      = ['connexion' => $connexion];
        return view('CreatePasswordView', $data);
    }

}
