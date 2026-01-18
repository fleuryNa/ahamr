<?php
namespace App\Controllers;

use App\Controllers\BaseController;

class SystemUser extends BaseController
{
    public function index()
    {
        //
        $profil = $this->model->datatable('SELECT `ID_PROFIL`,`PRO_DESCR` FROM `rh_profil` WHERE 1 ORDER BY `PRO_DESCR`');

        $data = ['profil' => $profil];
        return view('SystemUserView', $data);
    }
    public function listeUser()
    {
        #ici la recherche ne marche pas A cause de l'encryptage
        $var_search      = ! empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
        $var_search      = str_replace("'", "\'", $var_search);
        $query_principal = "SELECT `USER_ID`, `MATRICULE`, concat(`NOM`,' ', `PRENOM`) NOM, CONCAT(IFNULL(`TEL`, ''), '<br>', IFNULL(`EMAIL`, '')) AS CONTACT, TIMESTAMPDIFF(YEAR, `DATE_NAISSANCE`, CURDATE()) AS AGE , (CASE WHEN `ID_SEXE`=1 THEN 'Homme' ELSE 'Femme' END) sexe, `PHOTO`, `IS_ACTIVE`, rf.PRO_DESCR FROM `rh_users` ch JOIN rh_profil rf ON ch.ID_PROFIL=rf.ID_PROFIL WHERE 1";
        $group           = "";
        $critaire        = "";

        $limit = 'LIMIT 0,1000';
        if ($_POST['length'] != -1) {
            $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
        }
        $order_by     = '';
        $order_column = ['MATRICULE', 'NOM', 'TEL', 'DATE_NAISSANCE', 'PRO_DESCR', 'USER_ID'];
        if (isset($_POST['order'])) {
            if ($_POST['order']['0']['column'] != 0) {
                $order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY USER_ID DESC';
            }
        } else {
            $order_by = ' ORDER BY USER_ID DESC';
        }
        $search = ! empty($_POST['search']['value']) ? (" AND (NOM LIKE '%$var_search%' OR PRENOM LIKE '%$var_search%' OR TEL LIKE '%$var_search%' OR EMAIL LIKE '%$var_search%' OR MATRICULE LIKE '%$var_search%')") : '';

        $query_secondaire = $query_principal . '  ' . $critaire . ' ' . $search . ' ' . $group . ' ' . $order_by . '   ' . $limit;

        $query_filter = $query_principal . '  ' . $critaire . ' ' . $search . ' ' . $group;

        $fetch_intrants = $this->model->datatable($query_secondaire);

        $data = [];

        foreach ($fetch_intrants as $row) {

            $sub_array   = [];
            $sub_array[] = $row->USER_ID;
            $sub_array[] = $row->NOM;
            $sub_array[] = $row->CONTACT;

            $sub_array[] = $row->PRO_DESCR;

            $sub_array[] = ($row->IS_ACTIVE == 1) ? '<span class="badge bg-success">Actif</span>' : '<span class="badge bg-danger">Inactif</span>';
            $status      = ($row->IS_ACTIVE == 1) ? "Désactiver" : "Activer";
            //   <a href="' . base_url('chantier/detail/' . md5($row->ID_CHANTIER)) . '">Détail</a>
            $sub_array[] = '
                      <div class="btn-group">
                        <button class="lodge-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                          Action
                        </button>
                        <ul class="dropdown-menu">
                          <li>
                            <a class="dropdown-item"  href="#" onclick="resetPassword(' . $row->USER_ID . ')">Réinitaliser</a>
                          </li>
                          <li>
                            <a class="dropdown-item"  href="#" onclick="toggleUserStatus(' . $row->USER_ID . ',' . $row->IS_ACTIVE . ')">' . $status . '</a>
                          </li>
                        </ul>
                      </div>
            ';
            $data[] = $sub_array;

        }

        $output = [
            "draw"            => intval($_POST['draw']),
            "recordsTotal"    => $this->model->all_data($query_principal),
            "recordsFiltered" => $this->model->all_data($query_filter),
            "data"            => $data,
        ];
        return $this->response->setJSON($output);
    }
    /**
     * cette fonction permet de créer un utilisateur
     *
     * @return void
     */
    public function addUser()
    {
        $rules = [
            'NOM'            => 'required|max_length[100]',
            'PRENOM'         => 'required|max_length[100]',
            'TEL'            => 'required|regex_match[/^[0-9]{8,15}$/]',
            'DATE_NAISSANCE' => 'required|valid_date',
            'EMAIL'          => 'permit_empty|valid_email',
            'ID_SEXE'        => 'required|integer',
            'ID_PROFIL'      => 'required',
        ];

        // Validation
        if (! $this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'errors'  => $this->validator->getErrors(),
            ]);
        }

        // Insérer les données si validation réussie
        $data = [
            'NOM'            => $this->request->getPost('NOM'),
            'PRENOM'         => $this->request->getPost('PRENOM'),
            'TEL'            => $this->request->getPost('TEL'),
            'DATE_NAISSANCE' => $this->request->getPost('DATE_NAISSANCE'),
            'EMAIL'          => $this->request->getPost('EMAIL'),
            'ID_SEXE'        => $this->request->getPost('ID_SEXE'),
            'ID_PROFIL'      => $this->request->getPost('ID_PROFIL'),
            'PASSWORD'       => sha1(12345),
        ];
        try {

            $this->model->create('rh_users', $data);

            return $this->response->setJSON([
                'success' => true,
            ]);
        } catch (\Throwable $th) {
            return $this->response->setJSON([
                'success' => false,
                'errors'  => $th,
            ]);
        }

    }
    public function resetPassword()
    {
        $userId = $this->request->getPost('user_id');

        if (! $userId) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ID manquant']);
        }

        // Nouveau mot de passe par défaut
        $newPassword = sha1('12345');
        $update      = $this->model->updateData('rh_users', ['USER_ID' => $userId], ['PASSWORD' => $newPassword, 'CREATE_PASSWORD' => 0]);

        if ($update) {
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Impossible de réinitialiser']);
        }
    }

    public function toggleStatus()
    {
        $userId = $this->request->getPost('user_id');
        $action = $this->request->getPost('action');

        if (! $userId || $action == "") {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Données manquantes']);
        }
        $actio = 0;
        if ($action == 0) {
            # code...
            $actio = 1;
        }

        $update = $this->model->updateData('rh_users', ['USER_ID' => $userId], ['IS_ACTIVE' => $actio]);

        if ($update) {
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Échec de la mise à jour']);
        }
    }

}
