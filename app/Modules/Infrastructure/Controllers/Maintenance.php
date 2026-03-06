<?php
namespace Modules\Infrastructure\Controllers;

use App\Controllers\BaseController;

class Maintenance extends BaseController
{
    public function index()
    {
        $data['provinces'] = $this->model->getRequete('SELECT * FROM provinces');
        return view('Modules\Infrastructure\Views\MaintenanceView', $data);
    }
    /**
     * liste des  maintenances realisées sur les infrastructures.
     *
     * @return json
     */
    public function getMaintenance(): mixed
    {
        $STATUT_ID = ($this->request->getPost('STATUT_ID')) ? $this->request->getPost('STATUT_ID') : 0;
        $AEP_ID    = ($this->request->getPost('AEP_ID')) ? $this->request->getPost('AEP_ID') : null;
        $cond      = "";
        if ($AEP_ID != null) {
            $cond = " AND m.AEP_ID = $AEP_ID";
        }
        $var_search      = ! empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
        $var_search      = str_replace("'", "\'", $var_search);
        $query_principal = "SELECT MAINTENANCE_ID,STATUT_ID, i.CODE, i.NOM, ti.DESCRIPTION AS TYPE, `DATE_MAINTENANCE`, CONCAT(u.NOM, ' ', u.PRENOM) COLLECTEUR, CONCAT(uv.NOM, ' ', uv.PRENOM) VALIDATEUR, `COMMENTAIRE`, `OBSERVATION_VALIDATION` FROM `maintenance` m JOIN aep_infrastructures i ON m.INFRA_ID = i.INFRA_ID JOIN type_infrastructure ti ON i.TYPE_INFRA_ID = ti.TYPE_AEP_ID JOIN rh_users u ON u.USER_ID = m.USER_ID JOIN rh_users uv ON uv.USER_ID = m.USER_VALIDATEUR WHERE STATUT_ID= $STATUT_ID " . $cond;

        $group    = "";
        $critaire = "";

        $limit = 'LIMIT 0,1000';
        if ($_POST['length'] != -1) {
            $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
        }
        $order_by     = '';
        $order_column = ['MAINTENANCE_ID',
            'TYPE',
            'CODE',
            'NOM',
            'DATE_MAINTENANCE',
            'COMMENTAIRE',
            'OBSERVATION_VALIDATION',
            'COLLECTEUR',
            'VALIDATEUR', 'MAINTENANCE_ID'];
        if (isset($_POST['order'])) {
            if ($_POST['order']['0']['column'] != 0) {
                $order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY MAINTENANCE_ID DESC';
            }
        } else {
            $order_by = ' ORDER BY ti.DESCRIPTION DESC';
        }
        $search = ! empty($_POST['search']['value']) ? (" AND (ti.DESCRIPTION LIKE '%$var_search%' OR CODE LIKE '%$var_search%')") : '';

        $query_secondaire = $query_principal . '  ' . $critaire . ' ' . $search . ' ' . $group . ' ' . $order_by . '   ' . $limit;

        $query_filter = $query_principal . '  ' . $critaire . ' ' . $search . ' ' . $group;

        $fetch_captage = $this->model->datatable($query_secondaire);

        $data = [];
        $i    = 0;
        foreach ($fetch_captage as $row) {

            $i++;
            $sub_array = [];
            if ($row->STATUT_ID == 0) {
                $sub_array[] = '<input type="checkbox" class="select-row" value="' . $row->MAINTENANCE_ID . '">';
            } else {
                $sub_array[] = '';
                // $sub_array[] = '<input type="checkbox" class="select-row" value="' . $row->MAINTENANCE_ID . '">';

            }
            $sub_array[] = $row->TYPE;
            $sub_array[] = $row->CODE;
            $sub_array[] = $row->NOM;
            $sub_array[] = $row->DATE_MAINTENANCE;
            $sub_array[] = $row->COMMENTAIRE;
            $sub_array[] = $row->OBSERVATION_VALIDATION;
            $sub_array[] = $row->COLLECTEUR;
            $sub_array[] = $row->VALIDATEUR;
            $sub_array[] = '<span onclick="voirDetails(' . $row->MAINTENANCE_ID . ')" class="text-center" style="cursor:mouce-pointer;"><i class="bi bi-eye"></i></span>';
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
    public function validerMaintenance()
    {
        if (! $this->request->isAJAX()) {
            return $this->response->setStatusCode(403);
        }

        $json        = $this->request->getJSON();
        $ids         = $json->ids ?? [];
        $observation = trim($json->observation ?? '');
        if (empty($ids)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Aucune maintenance sélectionnée',
            ]);
        }

        if (empty($observation)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'L\'observation est requise',
            ]);
        }
        $db = db_connect();
        $db->transBegin();

        try {
            $userId = $this->session->get('userdata')['USER_ID'];
            $now    = date('Y-m-d H:i:s');

            foreach ($ids as $id) {
                $data = [
                    'STATUT_ID'              => 1, // Nouveau statut (validé)
                    'OBSERVATION_VALIDATION' => $observation,
                    'USER_VALIDATEUR'        => $userId,
                    'DATE_MODIFICATION'      => $now,
                ];
                $db->table('maintenance')
                    ->where('MAINTENANCE_ID', $id)
                    ->update($data);
            }

            $db->transCommit();

            return $this->response->setJSON([
                'success' => true,
                'message' => count($ids) . ' maintenance(s) validée(s) avec succès',
            ]);

        } catch (\Exception $e) {
            $db->transRollback();

            log_message('error', '[Maintenance] Erreur validation multiple: ' . $e->getMessage());

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Erreur lors de la validation',
            ]);
        }
    }
    public function getMaintenanceById($id)
    {
        $query  = "SELECT MAINTENANCE_ID,STATUT_ID,m.`DATE_ENREGISTREMENT`,m.`DATE_MODIFICATION`,(CASE WHEN `STATUT_ID`=1 THEN 'Validé' ELSE 'En attente de validation' END) DONNE_VALIDE, i.CODE, i.NOM, ti.DESCRIPTION AS TYPE, `DATE_MAINTENANCE`, CONCAT(u.NOM, ' ', u.PRENOM) COLLECTEUR, CONCAT(uv.NOM, ' ', uv.PRENOM) VALIDATEUR, `COMMENTAIRE`, `OBSERVATION_VALIDATION`,m.`PHOTO`,p.PROVINCE_NAME,c.COMMUNE_NAME,aep.NOM AEP FROM `maintenance` m JOIN aep_infrastructures i ON m.INFRA_ID = i.INFRA_ID JOIN type_infrastructure ti ON i.TYPE_INFRA_ID = ti.TYPE_AEP_ID JOIN rh_users u ON u.USER_ID = m.USER_ID JOIN rh_users uv ON uv.USER_ID = m.USER_VALIDATEUR JOIN provinces p  ON m.PROVINCE_ID=p.PROVINCE_ID JOIN communes c ON m.COMMUNE_ID=c.COMMUNE_ID JOIN aep ON aep.AEP_ID=m.AEP_ID WHERE MAINTENANCE_ID = $id";
        $result = $this->model->getRequeteOne($query);

        if ($result) {
            return $this->response->setJSON([
                'success' => true,
                'data'    => $result,
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Maintenance non trouvée',
        ]);
    }

}
