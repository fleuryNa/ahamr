<?php
namespace Modules\Infrastructure\Controllers;

use App\Controllers\BaseController;

class Infrastructure extends BaseController
{

    public function index()
    {
        //
        $provinces                        = $this->model->getRequete('SELECT `PROVINCE_ID`,`PROVINCE_NAME` FROM `provinces` ORDER BY`PROVINCE_NAME`');
        $aep_type_branchement             = $this->model->getRequete('SELECT * FROM `aep_type_branchement` ORDER BY `DESCRIPTION`');
        $type_infrastructure              = $this->model->getRequete('SELECT * FROM `type_infrastructure` ORDER BY `DESCRIPTION`');
        $aep_type_chambre                 = $this->model->getRequete('SELECT * FROM `aep_type_chambre` ORDER BY `TYPE_CHAMBRE_DESCR`');
        $aep_type_materiel                = $this->model->getRequete('SELECT * FROM `aep_type_materiel` ORDER BY `DESCRIPTION`');
        $aep_branchement_type_institution = $this->model->getRequete('SELECT `BR_TYPE_INSTITUTION_ID`, `DESCRIPTION` FROM `aep_branchement_type_institution` order by `DESCRIPTION`');
        $data                             = [
            'provinces'                        => $provinces,
            'aep_type_branchement'             => $aep_type_branchement,
            'type_infrastructure'              => $type_infrastructure,
            'aep_type_chambre'                 => $aep_type_chambre,
            'aep_type_materiel'                => $aep_type_materiel,
            'aep_branchement_type_institution' => $aep_branchement_type_institution,
        ];
        return view('Modules\Infrastructure\Views\InfrastructureView', $data);
    }
    public function getCommuneByProvince()
    {
        $province_id = $this->request->getPost('province_id');
        $communes    = $this->model->getRequete("SELECT `COMMUNE_ID`,`COMMUNE_NAME` FROM `communes` WHERE PROVINCE_ID='$province_id' ORDER BY `COMMUNE_NAME`");
        return $this->response->setJSON($communes);
    }
    public function getZoneByCommune()
    {
        $commune_id = $this->request->getPost('commune_id');
        $zones      = $this->model->getRequete("SELECT `ZONE_ID`,`ZONE_NAME` FROM `zones` WHERE `COMMUNE_ID`='$commune_id' ORDER BY `ZONE_NAME`");
        return $this->response->setJSON($zones);
    }
    public function getCollineByZone()
    {
        $zone_id  = $this->request->getPost('zone_id');
        $collines = $this->model->getRequete("SELECT `COLLINE_ID`,`COLLINE_NAME` FROM `collines` WHERE `ZONE_ID`='$zone_id' ORDER BY `COLLINE_NAME`");
        return $this->response->setJSON($collines);
    }
    public function getAepByCommune()
    {
        $commune_id = $this->request->getPost('commune_id');
        $aeps       = $this->model->getRequete("SELECT `AEP_ID`,`NOM` FROM `aep` WHERE `COMMUNE_ID`='$commune_id' ORDER BY `NOM`");
        return $this->response->setJSON($aeps);
    }
    /**
     * liste des infrastructure de type captage
     *
     * @return json
     */
    public function getInfraCaptage(): mixed
    {
        $var_search      = ! empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
        $var_search      = str_replace("'", "\'", $var_search);
        $query_principal = "SELECT `INFRA_ID`, i.CODE, p.PROVINCE_NAME, c.COMMUNE_NAME, e.DESCRIPTION ETAT, a.NOM NOM_RESEAU, `DEBIT`, ( CASE WHEN `FONCTIONNALITE_ID` = 1 THEN 'FONCTIONNEL' ELSE 'NON FONCTIONNEL' END ) FONCTIONNEL FROM `aep_infrastructures` i JOIN provinces p ON i.`PROVINCE` = p.PROVINCE_ID JOIN communes c ON i.COMMUNE = c.COMMUNE_ID JOIN aep_etat e ON i.ETAT_ID = e.ETAT_ID JOIN aep a ON i.AEP = a.AEP_ID WHERE `TYPE_INFRA_ID`=1";

        $group    = "";
        $critaire = "";

        $limit = 'LIMIT 0,1000';
        if ($_POST['length'] != -1) {
            $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
        }
        $order_by     = '';
        $order_column = ['INFRA_ID',
            'PROVINCE_NAME',
            'COMMUNE_NAME',
            'NOM_RESEAU',
            'FONCTIONNEL',
            'ETAT',
            'DEBIT',
            'CODE', 'CODE'];
        if (isset($_POST['order'])) {
            if ($_POST['order']['0']['column'] != 0) {
                $order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY INFRA_ID DESC';
            }
        } else {
            $order_by = ' ORDER BY NOM_RESEAU DESC';
        }
        $search = ! empty($_POST['search']['value']) ? (" AND (NOM_RESEAU LIKE '%$var_search%' OR CODE LIKE '%$var_search%')") : '';

        $query_secondaire = $query_principal . '  ' . $critaire . ' ' . $search . ' ' . $group . ' ' . $order_by . '   ' . $limit;

        $query_filter = $query_principal . '  ' . $critaire . ' ' . $search . ' ' . $group;

        $fetch_captage = $this->model->datatable($query_secondaire);

        $data = [];
        $i    = 0;
        foreach ($fetch_captage as $row) {

            $i++;
            $sub_array   = [];
            $sub_array[] = $i;
            $sub_array[] = $row->PROVINCE_NAME;
            $sub_array[] = $row->COMMUNE_NAME;
            $sub_array[] = $row->NOM_RESEAU;
            $sub_array[] = $row->FONCTIONNEL;
            $sub_array[] = $row->ETAT;
            $sub_array[] = $row->DEBIT;
            $sub_array[] = $row->CODE;
            $sub_array[] = '<span onclick="modifier(' . $row->INFRA_ID . ')" class="text-center" style="cursor:mouce-pointer;"><i class="bi bi-pencil-square"></i></span>';
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
    /**
     * liste des infra type chambre
     *
     * @return mixed
     */
    public function getInfraChambre(): mixed
    {
        $var_search      = ! empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
        $var_search      = str_replace("'", "\'", $var_search);
        $query_principal = "SELECT `INFRA_ID`,i.CODE,p.PROVINCE_NAME,c.COMMUNE_NAME,e.DESCRIPTION ETAT,a.NOM NOM_RESEAU,`DEBIT`,(CASE WHEN `FONCTIONNALITE_ID`=1 THEN 'FONCTIONNEL' ELSE  'NON FONCTIONNEL' END) FONCTIONNEL,ch.TYPE_CHAMBRE_DESCR  FROM `aep_infrastructures` i JOIN provinces p ON i.PROVINCE=p.PROVINCE_ID JOIN communes c ON i.COMMUNE=c.COMMUNE_ID JOIN aep_etat e ON i.ETAT_ID=e.ETAT_ID JOIN aep a ON i.AEP=a.AEP_ID JOIN aep_type_chambre ch ON i.TYPE_CHAMBRE_ID=ch.TYPE_CHAMBRE_ID WHERE `TYPE_INFRA_ID`=2";

        $group    = "";
        $critaire = "";

        $limit = 'LIMIT 0,1000';
        if ($_POST['length'] != -1) {
            $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
        }
        $order_by     = '';
        $order_column = ['INFRA_ID',
            'PROVINCE_NAME',
            'COMMUNE_NAME',
            'NOM_RESEAU',
            'FONCTIONNEL',
            'ETAT',
            'TYPE_CHAMBRE_DESCR',
            'CODE', 'CODE'];
        if (isset($_POST['order'])) {
            if ($_POST['order']['0']['column'] != 0) {
                $order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY INFRA_ID DESC';
            }
        } else {
            $order_by = ' ORDER BY NOM_RESEAU DESC';
        }
        $search = ! empty($_POST['search']['value']) ? (" AND (NOM_RESEAU LIKE '%$var_search%' OR CODE LIKE '%$var_search%')") : '';

        $query_secondaire = $query_principal . '  ' . $critaire . ' ' . $search . ' ' . $group . ' ' . $order_by . '   ' . $limit;

        $query_filter = $query_principal . '  ' . $critaire . ' ' . $search . ' ' . $group;

        $fetch_captage = $this->model->datatable($query_secondaire);

        $data = [];
        $i    = 0;
        foreach ($fetch_captage as $row) {

            $i++;
            $sub_array   = [];
            $sub_array[] = $i;
            $sub_array[] = $row->PROVINCE_NAME;
            $sub_array[] = $row->COMMUNE_NAME;
            $sub_array[] = $row->NOM_RESEAU;
            $sub_array[] = $row->FONCTIONNEL;
            $sub_array[] = $row->ETAT;
            $sub_array[] = $row->TYPE_CHAMBRE_DESCR;
            $sub_array[] = $row->CODE;
            $sub_array[] = '<span onclick="modifier(' . $row->INFRA_ID . ')" class="text-center" style="cursor:mouce-pointer;"><i class="bi bi-pencil-square"></i></span>';
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
    /**
     * liste des conduites
     *
     * @return mixed
     */
    public function getInfraConduite(): mixed
    {
        $var_search      = ! empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
        $var_search      = str_replace("'", "\'", $var_search);
        $query_principal = "SELECT `INFRA_ID`,i.CODE,p.PROVINCE_NAME,c.COMMUNE_NAME,e.DESCRIPTION ETAT,a.NOM NOM_RESEAU,`DIAMETRE`,`LONGUEUR`,`PN`,(CASE WHEN `FONCTIONNALITE_ID`=1 THEN 'FONCTIONNEL' ELSE 'NON FONCTIONNEL' END) FONCTIONNEL,mat.DESCRIPTION AS MATERIAU FROM `aep_infrastructures` i JOIN provinces p ON i.PROVINCE=p.PROVINCE_ID JOIN communes c ON i.COMMUNE=c.COMMUNE_ID JOIN aep_etat e ON i.ETAT_ID=e.ETAT_ID JOIN aep a ON i.AEP=a.AEP_ID JOIN aep_type_materiel mat ON i.MATERIEL_TYPE_ID=mat.TYPE_MATERIEL_ID WHERE `TYPE_INFRA_ID`=3";

        $group    = "";
        $critaire = "";

        $limit = 'LIMIT 0,1000';
        if ($_POST['length'] != -1) {
            $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
        }
        $order_by     = '';
        $order_column = ['INFRA_ID',
            'PROVINCE_NAME',
            'COMMUNE_NAME',
            'NOM_RESEAU',
            'FONCTIONNEL',
            'ETAT',
            'DIAMETRE',
            'PN', 'LONGUEUR', 'INFRA_ID'];
        if (isset($_POST['order'])) {
            if ($_POST['order']['0']['column'] != 0) {
                $order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY INFRA_ID DESC';
            }
        } else {
            $order_by = ' ORDER BY NOM_RESEAU DESC';
        }
        $search = ! empty($_POST['search']['value']) ? (" AND (NOM_RESEAU LIKE '%$var_search%' OR CODE LIKE '%$var_search%')") : '';

        $query_secondaire = $query_principal . '  ' . $critaire . ' ' . $search . ' ' . $group . ' ' . $order_by . '   ' . $limit;

        $query_filter = $query_principal . '  ' . $critaire . ' ' . $search . ' ' . $group;

        $fetch_captage = $this->model->datatable($query_secondaire);

        $data = [];
        $i    = 0;
        foreach ($fetch_captage as $row) {

            $i++;
            $sub_array   = [];
            $sub_array[] = $i;
            $sub_array[] = $row->PROVINCE_NAME;
            $sub_array[] = $row->COMMUNE_NAME;
            $sub_array[] = $row->NOM_RESEAU;
            $sub_array[] = $row->FONCTIONNEL;
            $sub_array[] = $row->ETAT;
            $sub_array[] = $row->DIAMETRE;
            $sub_array[] = $row->PN;
            $sub_array[] = $row->LONGUEUR;
            $sub_array[] = $row->MATERIAU;
            $sub_array[] = '<span onclick="modifier(' . $row->INFRA_ID . ')" class="text-center" style="cursor:mouce-pointer;"><i class="bi bi-pencil-square"></i></span>';
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
    /**
     * liste des reservoir
     *
     * @return mixed
     */
    public function getInfraReservoir(): mixed
    {
        $var_search      = ! empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
        $var_search      = str_replace("'", "\'", $var_search);
        $query_principal = "SELECT `INFRA_ID`,i.CODE,p.PROVINCE_NAME,c.COMMUNE_NAME,e.DESCRIPTION ETAT,a.NOM NOM_RESEAU,`VOLUME`,(CASE WHEN `FONCTIONNALITE_ID`=1 THEN 'FONCTIONNEL' ELSE 'NON FONCTIONNEL' END) FONCTIONNEL FROM `aep_infrastructures` i JOIN provinces p ON i.PROVINCE=p.PROVINCE_ID JOIN communes c ON i.COMMUNE=c.COMMUNE_ID JOIN aep_etat e ON i.ETAT_ID=e.ETAT_ID JOIN aep a ON i.AEP=a.AEP_ID WHERE `TYPE_INFRA_ID`=4";

        $group    = "";
        $critaire = "";

        $limit = 'LIMIT 0,1000';
        if ($_POST['length'] != -1) {
            $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
        }
        $order_by     = '';
        $order_column = ['INFRA_ID',
            'PROVINCE_NAME',
            'COMMUNE_NAME',
            'NOM_RESEAU',
            'FONCTIONNEL',
            'ETAT',
            'VOLUME',
            'INFRA_ID'];
        if (isset($_POST['order'])) {
            if ($_POST['order']['0']['column'] != 0) {
                $order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY INFRA_ID DESC';
            }
        } else {
            $order_by = ' ORDER BY NOM_RESEAU DESC';
        }
        $search = ! empty($_POST['search']['value']) ? (" AND (NOM_RESEAU LIKE '%$var_search%' OR CODE LIKE '%$var_search%')") : '';

        $query_secondaire = $query_principal . '  ' . $critaire . ' ' . $search . ' ' . $group . ' ' . $order_by . '   ' . $limit;

        $query_filter = $query_principal . '  ' . $critaire . ' ' . $search . ' ' . $group;

        $fetch_captage = $this->model->datatable($query_secondaire);

        $data = [];
        $i    = 0;
        foreach ($fetch_captage as $row) {

            $i++;
            $sub_array   = [];
            $sub_array[] = $i;
            $sub_array[] = $row->PROVINCE_NAME;
            $sub_array[] = $row->COMMUNE_NAME;
            $sub_array[] = $row->NOM_RESEAU;
            $sub_array[] = $row->FONCTIONNEL;
            $sub_array[] = $row->ETAT;
            $sub_array[] = $row->VOLUME;
            $sub_array[] = $row->CODE;

            $sub_array[] = '<span onclick="modifier(' . $row->INFRA_ID . ')" class="text-center" style="cursor:mouce-pointer;"><i class="bi bi-pencil-square"></i></span>';
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
    /**
     * liste des bornes fontaines
     *
     * @return mixed
     */
    public function getInfraBf(): mixed
    {
        $var_search      = ! empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
        $var_search      = str_replace("'", "\'", $var_search);
        $query_principal = "SELECT `INFRA_ID`,i.NUMERO_COMPTEUR,i.NOM,i.CODE,p.PROVINCE_NAME,c.COMMUNE_NAME,e.DESCRIPTION ETAT,a.NOM NOM_RESEAU,`VOLUME`,(CASE WHEN `FONCTIONNALITE_ID`=1 THEN 'FONCTIONNEL' ELSE 'NON FONCTIONNEL' END) FONCTIONNEL,tb.DESCRIPTION TYPE_BRANCHEMENT, concat(ti.DESCRIPTION,'(',i.NOM_INSTITUTION,')') INSTUTITION FROM `aep_infrastructures` i JOIN provinces p ON i.PROVINCE=p.PROVINCE_ID JOIN communes c ON i.COMMUNE=c.COMMUNE_ID JOIN aep_etat e ON i.ETAT_ID=e.ETAT_ID JOIN aep a ON i.AEP=a.AEP_ID JOIN aep_type_branchement tb ON i.TYPE_BRANCHEMENT_ID=tb.TYPE_BRANCHEMENT_ID LEFT JOIN aep_branchement_type_institution ti ON i.BR_TYPE_INSTITUTION_ID=ti.BR_TYPE_INSTITUTION_ID WHERE `TYPE_INFRA_ID`=5";

        $group    = "";
        $critaire = "";

        $limit = 'LIMIT 0,1000';
        if ($_POST['length'] != -1) {
            $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
        }
        $order_by     = '';
        $order_column = ['INFRA_ID',
            'PROVINCE_NAME',
            'COMMUNE_NAME',
            'NOM_RESEAU',
            'FONCTIONNEL',
            'ETAT',
            'i.NOM', 'TYPE_BRANCHEMENT', 'NOM_INSTUTITION', 'NUMERO_COMPTEUR',
            'CODE',
            'INFRA_ID'];
        if (isset($_POST['order'])) {
            if ($_POST['order']['0']['column'] != 0) {
                $order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY INFRA_ID DESC';
            }
        } else {
            $order_by = ' ORDER BY NOM_RESEAU DESC';
        }
        $search = ! empty($_POST['search']['value']) ? (" AND (NOM_RESEAU LIKE '%$var_search%' OR i.NOM LIKE '%$var_search%' OR CODE LIKE '%$var_search%')") : '';

        $query_secondaire = $query_principal . '  ' . $critaire . ' ' . $search . ' ' . $group . ' ' . $order_by . '   ' . $limit;

        $query_filter = $query_principal . '  ' . $critaire . ' ' . $search . ' ' . $group;

        $fetch_captage = $this->model->datatable($query_secondaire);

        $data = [];
        $i    = 0;
        foreach ($fetch_captage as $row) {

            $i++;
            $sub_array   = [];
            $sub_array[] = $i;
            $sub_array[] = $row->PROVINCE_NAME;
            $sub_array[] = $row->COMMUNE_NAME;
            $sub_array[] = $row->NOM_RESEAU;
            $sub_array[] = $row->FONCTIONNEL;
            $sub_array[] = $row->ETAT;
            $sub_array[] = $row->NOM;
            $sub_array[] = $row->TYPE_BRANCHEMENT;
            $sub_array[] = $row->INSTUTITION;
            $sub_array[] = $row->NUMERO_COMPTEUR;
            $sub_array[] = $row->CODE;

            $sub_array[] = '<span onclick="modifier(' . $row->INFRA_ID . ')" class="text-center" style="cursor:mouce-pointer;"><i class="bi bi-pencil-square"></i></span>';
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
    /**
     * Sauvegarder une infrastructure (Ajout ou Modification)
     */
    public function enregistrerInfra()
    {
        // Vérifier si c'est une requête AJAX
        if (! $this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'Accès non autorisé',
            ]);
        }

        // Règles de validation de base
        $rules = [
            'PROVINCE'          => 'required|integer',
            'COMMUNE'           => 'required|integer',
            'AEP'               => 'required|integer',
            'TYPE_INFRA_ID'     => 'required|integer|in_list[1,2,3,4,5]',
            'ETAT_ID'           => 'required|integer|in_list[1,2]',
            'FONCTIONNALITE_ID' => 'required|integer|in_list[1,2]',
            'NOM'               => 'required|min_length[2]|max_length[255]',
        ];

        // Ajouter les règles de validation selon le type d'infrastructure
        $typeInfra = $this->request->getPost('TYPE_INFRA_ID');

        switch ($typeInfra) {
            case 1: // Captage
                $rules['DEBIT'] = 'required|numeric|greater_than[0]';
                break;

            case 2: // Chambre
                $rules['TYPE_CHAMBRE_ID'] = 'required|integer';
                break;

            case 3: // Conduite
                $rules['DIAMETRE']         = 'required|numeric|greater_than[0]';
                $rules['PN']               = 'required|numeric|greater_than[0]';
                $rules['LONGUEUR']         = 'required|numeric|greater_than[0]';
                $rules['MATERIEL_TYPE_ID'] = 'required|integer';
                break;

            case 4: // Réservoir
                $rules['VOLUME'] = 'required|numeric|greater_than[0]';
                break;

            case 5: // Branchement (BF)
                $rules['TYPE_BRANCHEMENT_ID'] = 'required|integer';
                if ($this->request->getPost('TYPE_BRANCHEMENT_ID') == 1) {                   // Si c'est branchement publique
                    $rules['NOM_INSTITUTION']        = 'required|min_length[2]|max_length[255]'; // Le nom est obligatoire pour les bornes fontaines
                    $rules['BR_TYPE_INSTITUTION_ID'] = 'required';                               // Le nom est obligatoire pour les bornes fontaines
                }
                break;
        }

        // Valider les données
        if (! $this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors'  => $this->validator->getErrors(),
            ]);
        }

        // Récupérer les données validées
        $postData = $this->request->getPost();

        // Préparer les données pour la base
        $data = [
            'PROVINCE'          => $postData['PROVINCE'],
            'COMMUNE'           => $postData['COMMUNE'],
            'AEP'               => $postData['AEP'],
            'TYPE_INFRA_ID'     => $postData['TYPE_INFRA_ID'],
            'ETAT_ID'           => $postData['ETAT_ID'],
            'FONCTIONNALITE_ID' => $postData['FONCTIONNALITE_ID'],
            'NOM'               => $postData['NOM'],
            'USER_ID'           => $this->session->get('userdata')['USER_ID'], //utilisateur connecté
        ];

        // Ajouter les champs spécifiques selon le type
        switch ($typeInfra) {
            case 1: // Captage
                $data['DEBIT']                  = $postData['DEBIT'];
                $data['TYPE_CHAMBRE_ID']        = null;
                $data['DIAMETRE']               = null;
                $data['PN']                     = null;
                $data['LONGUEUR']               = null;
                $data['MATERIEL_TYPE_ID']       = null;
                $data['VOLUME']                 = null;
                $data['TYPE_BRANCHEMENT_ID']    = null;
                $data['BR_TYPE_INSTITUTION_ID'] = null;
                $data['NOM_INSTITUTION']        = null;
                $data['NUMERO_COMPTEUR']        = null;

                break;

            case 2: // Chambre
                $data['DEBIT']                  = null;
                $data['TYPE_CHAMBRE_ID']        = $postData['TYPE_CHAMBRE_ID'];
                $data['DIAMETRE']               = null;
                $data['PN']                     = null;
                $data['LONGUEUR']               = null;
                $data['MATERIEL_TYPE_ID']       = null;
                $data['VOLUME']                 = null;
                $data['TYPE_BRANCHEMENT_ID']    = null;
                $data['BR_TYPE_INSTITUTION_ID'] = null;
                $data['NOM_INSTITUTION']        = null;
                $data['NUMERO_COMPTEUR']        = null;
                break;

            case 3: // Conduite
                $data['DEBIT']                  = null;
                $data['TYPE_CHAMBRE_ID']        = null;
                $data['DIAMETRE']               = $postData['DIAMETRE'];
                $data['PN']                     = $postData['PN'];
                $data['LONGUEUR']               = $postData['LONGUEUR'];
                $data['MATERIEL_TYPE_ID']       = $postData['MATERIEL_TYPE_ID'];
                $data['VOLUME']                 = null;
                $data['TYPE_BRANCHEMENT_ID']    = null;
                $data['BR_TYPE_INSTITUTION_ID'] = null;
                $data['NOM_INSTITUTION']        = null;
                $data['NUMERO_COMPTEUR']        = null;
                break;

            case 4: // Réservoir
                $data['DEBIT']                  = null;
                $data['TYPE_CHAMBRE_ID']        = null;
                $data['DIAMETRE']               = null;
                $data['PN']                     = null;
                $data['LONGUEUR']               = null;
                $data['MATERIEL_TYPE_ID']       = null;
                $data['VOLUME']                 = $postData['VOLUME'];
                $data['TYPE_BRANCHEMENT_ID']    = null;
                $data['BR_TYPE_INSTITUTION_ID'] = null;
                $data['NOM_INSTITUTION']        = null;
                $data['NUMERO_COMPTEUR']        = null;
                break;

            case 5: // Branchement
                $data['DEBIT']                  = null;
                $data['TYPE_CHAMBRE_ID']        = null;
                $data['DIAMETRE']               = null;
                $data['PN']                     = null;
                $data['LONGUEUR']               = null;
                $data['MATERIEL_TYPE_ID']       = null;
                $data['VOLUME']                 = null;
                $data['TYPE_BRANCHEMENT_ID']    = $postData['TYPE_BRANCHEMENT_ID'];
                $data['BR_TYPE_INSTITUTION_ID'] = $postData['BR_TYPE_INSTITUTION_ID'];
                $data['NOM_INSTITUTION']        = $postData['NOM_INSTITUTION'];
                $data['NUMERO_COMPTEUR']        = $postData['NUMERO_COMPTEUR'];

                break;
        }
        $db = db_connect();
        // Commencer une transaction
        $db->transBegin();

        try {
            // Déterminer s'il s'agit d'une modification ou d'un ajout
            $infraId = $this->request->getPost('infra_id');

            if ($infraId && ! empty($infraId)) {
                // Mise à jour
                $data['DATE_MODIFICATION'] = date('Y-m-d H:i:s');
                $db->table('aep_infrastructures')
                    ->where('INFRA_ID', $infraId)
                    ->update($data);
                $result  = $infraId;
                $message = 'Infrastructure mise à jour avec succès';
            } else {
                // Ajout
                helper('number');
                $data['CODE']          = generateInfraCode($data['PROVINCE'], $data['COMMUNE'], $data['TYPE_INFRA_ID']);
                $data['DATE_CREATION'] = date('Y-m-d H:i:s');
                $db->table('aep_infrastructures')->insert($data);
                $result  = $db->insertID();
                $message = 'Infrastructure ajoutée avec succès';
            }

            if ($result) {
                $db->transComplete();

                return $this->response->setJSON([
                    'success' => true,
                    'message' => $message,
                    'id'      => $result,
                ]);
            } else {
                throw new \Exception('Échec de l\'enregistrement');
            }

        } catch (\Exception $e) {
            $db->transRollback();

            log_message('error', '[Infrastructure] Erreur save: ' . $e->getMessage());

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Une erreur est survenue lors de l\'enregistrement',
            ]);
        }
    }
    /**
     * Récupérer une infrastructure pour modification
     */
    public function getInfra($id)
    {
        if (! $this->request->isAJAX()) {
            return $this->response->setStatusCode(403);
        }
        $sql = "SELECT
                    i.*,
                    p.PROVINCE_ID,
                    p.PROVINCE_NAME,
                    c.COMMUNE_ID,
                    c.COMMUNE_NAME,
                    a.AEP_ID,
                    a.NOM AS AEP_NOM
                FROM
                    aep_infrastructures i
                INNER JOIN
                    aep a ON a.AEP_ID = i.AEP
                INNER JOIN
                    communes c ON c.COMMUNE_ID = i.COMMUNE
                INNER JOIN
                    provinces p ON p.PROVINCE_ID = i.PROVINCE
                WHERE
                    i.INFRA_ID = $id";
        $data = $this->model->getRequeteOne($sql);

        if ($data) {
            return $this->response->setJSON([
                'success' => true,
                'data'    => $data,
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Infrastructure non trouvée',
        ]);
    }

}
