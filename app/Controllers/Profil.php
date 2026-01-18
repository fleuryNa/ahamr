<?php
namespace App\Controllers;

use App\Controllers\BaseController;

class Profil extends BaseController
{
    public function index()
    {
        //
        $profil = $this->model->datatable('SELECT * FROM `rh_profil` ORDER BY `rh_profil`.`PRO_DESCR` ASC');
        $role   = $this->model->datatable('SELECT * FROM `rh_role` WHERE 1 ORDER BY `rh_role`.`DESCR_ROLE` ASC');
        $data   = ['profil' => $profil, 'role' => $role];
        return view('ProfilView', $data);
    }
    public function addProfil()
    {
        $PRO_DESCR = $this->request->getPost('PRO_DESCR');
        $ID_PROFIL = $this->request->getPost('ID_PROFIL');
        $ID_ROLE   = $this->request->getPost('ID_ROLE') ?? []; // Retourne un tableau vide si null

        $rules = [
            'PRO_DESCR' => 'required|max_length[100]|is_unique[rh_profil.PRO_DESCR,ID_PROFIL,' . $ID_PROFIL . ']',
        ];

        // Validation
        if (! $this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'errors'  => $this->validator->getErrors(),
            ]);
        } else {
            if (intval($ID_PROFIL) > 0) {

                $this->model->updateData('rh_profil', ['ID_PROFIL' => $ID_PROFIL], ['PRO_DESCR' => $PRO_DESCR]);
                $this->model->deleteData('rh_role_profil', ['ID_PROFIL' => $ID_PROFIL]);
            } else {
                $ID_PROFIL = $this->model->insertLastId('rh_profil', ['PRO_DESCR' => $PRO_DESCR]);

            }
            foreach ($ID_ROLE as $key) {
                # code...
                $this->model->create('rh_role_profil', ['ID_ROLE' => $key, 'ID_PROFIL' => $ID_PROFIL]);
            }

            return $this->response->setJSON([
                'success' => true,
            ]);
        }

    }
    public function liste($value = 0)
    {
        #ici la recherche ne marche pas A cause de l'encryptage
        $var_search      = ! empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
        $var_search      = str_replace("'", "\'", $var_search);
        $query_principal = 'SELECT `ID_PROFIL`, `PRO_DESCR` FROM `rh_profil` WHERE 1';

        $group    = "";
        $critaire = "";

        $limit = 'LIMIT 0,1000';
        if ($_POST['length'] != -1) {
            $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
        }
        $order_by     = '';
        $order_column = ['PRO_DESCR', 'PRO_DESCR', 'ID_PROFIL'];
        if (isset($_POST['order'])) {
            if ($_POST['order']['0']['column'] != 0) {
                $order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY ID_PROFIL DESC';
            }
        } else {
            $order_by = ' ORDER BY ID_PROFIL DESC';
        }
        $search = ! empty($_POST['search']['value']) ? (" AND (PRO_DESCR LIKE '%$var_search%')") : '';

        $query_secondaire = $query_principal . '  ' . $critaire . ' ' . $search . ' ' . $group . ' ' . $order_by . '   ' . $limit;

        $query_filter = $query_principal . '  ' . $critaire . ' ' . $search . ' ' . $group;

        $fetch_intrants = $this->model->datatable($query_secondaire);

        $data = [];

        foreach ($fetch_intrants as $row) {

            $sql = "SELECT rh_role.DESCR_ROLE FROM `rh_role_profil`  JOIN rh_role ON rh_role_profil.ID_ROLE=rh_role.ID_ROLE  WHERE `ID_PROFIL`=" . $row->ID_PROFIL;

            $role = $this->model->datatable($sql);
            $rol  = '';
            foreach ($role as $key) {
                # code...
                $rol .= '<li>' . $key->DESCR_ROLE . '</li>';
            }

            $sub_array   = [];
            $sub_array[] = $row->PRO_DESCR;
            $sub_array[] = $rol;
            $sub_array[] = '<span onclick="modifier(' . $row->ID_PROFIL . ')" class="text-center" style="cursor:mouce-pointer;"><i class="bi bi-pencil-square"></i></span>';
            $data[]      = $sub_array;

        }

        $output = [
            "draw"            => intval($_POST['draw']),
            "recordsTotal"    => $this->model->all_data($query_principal),
            "recordsFiltered" => $this->model->all_data($query_filter),
            "data"            => $data,
        ];
        return $this->response->setJSON($output);
    }
    public function getRole()
    {
        $ID_PROFIL = $this->request->getPost('ID_PROFIL');
        $profol    = $this->model->getOne('rh_profil', ['ID_PROFIL' => $ID_PROFIL]);
        $sql       = "SELECT rh_role.ID_ROLE FROM `rh_role_profil`  JOIN rh_role ON rh_role_profil.ID_ROLE=rh_role.ID_ROLE  WHERE `ID_PROFIL`=" . $ID_PROFIL;

        $ID_ROLE = $this->model->datatable($sql);
        $ids     = [];
        foreach ($ID_ROLE as $key) {
            # code...
            $ids[] = $key->ID_ROLE;
        }
        $roles = $this->model->datatable('SELECT * FROM `rh_role` WHERE 1 ORDER BY `rh_role`.`DESCR_ROLE` ASC');
        $chbx  = '';
        foreach ($roles as $role) {
            $checked = '';
            if (in_array($role->ID_ROLE, $ids)) {
                # code...
                $checked = 'checked';

            }
            $chbx .= '      <div class="col-4">
                            <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="' . $role->ID_ROLE . '" id="ID_ROLE[' . $role->ID_ROLE . ']" name="ID_ROLE[' . $role->ID_ROLE . ']" ' . $checked . ' >
                            <label class="form-check-label" for="ID_ROLE[' . $role->ID_ROLE . ']">
                            ' . $role->DESCR_ROLE . '
                            </label></div></div>
         ';
        }

        return $this->response->setJSON([
            'success'   => true,
            'chbx'      => $chbx,
            'PRO_DESCR' => $profol['PRO_DESCR'],
            'ID_PROFIL' => $ID_PROFIL,

        ]);
    }

    public function role()
    {

        $data = [];

        return view('RoleView', $data);
    }

}
