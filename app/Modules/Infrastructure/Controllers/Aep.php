<?php
namespace Modules\Infrastructure\Controllers;

use App\Controllers\BaseController;

class Aep extends BaseController
{

    public function index()
    {
        $provinces      = $this->model->getRequete('SELECT `PROVINCE_ID`,`PROVINCE_NAME` FROM `provinces` ORDER BY`PROVINCE_NAME`');
        $typesDocuments = $this->model->getRequete('SELECT `TYPE_DOCUMENT_ID`,`TYPE_DOCUMENT_DESCR` FROM `aep_type_document` ORDER BY `TYPE_DOCUMENT_DESCR`');
        $data           = [
            'provinces'      => $provinces,
            'typesDocuments' => $typesDocuments,
        ];
        return view('Modules\Infrastructure\Views\AepView', $data);
    }
    /**
     * Sauvegarder une AEP (Ajout ou Modification)
     */
    public function enregistrerAep()
    {
        // Vérifier si c'est une requête AJAX
        if (! $this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'Accès non autorisé',
            ]);
        }

        // Règles de validation - TOUS LES CHAMPS SONT OBLIGATOIRES
        $rules = [
            'NOM'                        => [
                'rules'  => 'required|min_length[2]|max_length[255]',
                'errors' => [
                    'required'   => 'Le nom de l\'AEP est obligatoire',
                    'min_length' => 'Le nom doit contenir au moins 2 caractères',
                    'max_length' => 'Le nom ne peut dépasser 255 caractères',
                ],
            ],
            'PROVINCE_ID'                => [
                'rules'  => 'required|integer|is_not_unique[provinces.PROVINCE_ID]',
                'errors' => [
                    'required'      => 'La province est obligatoire',
                    'integer'       => 'Province invalide',
                    'is_not_unique' => 'La province sélectionnée n\'existe pas',
                ],
            ],
            'COMMUNE_ID'                 => [
                'rules'  => 'required|integer|is_not_unique[communes.COMMUNE_ID]',
                'errors' => [
                    'required'      => 'La commune est obligatoire',
                    'integer'       => 'Commune invalide',
                    'is_not_unique' => 'La commune sélectionnée n\'existe pas',
                ],
            ],
            'ZONE_ID'                    => [
                'rules'  => 'required|integer|is_not_unique[zones.ZONE_ID]',
                'errors' => [
                    'required'      => 'La zone est obligatoire',
                    'integer'       => 'Zone invalide',
                    'is_not_unique' => 'La zone sélectionnée n\'existe pas',
                ],
            ],
            'COLLINE_ID'                 => [
                'rules'  => 'required|integer|is_not_unique[collines.COLLINE_ID]',
                'errors' => [
                    'required'      => 'La colline est obligatoire',
                    'integer'       => 'Colline invalide',
                    'is_not_unique' => 'La colline sélectionnée n\'existe pas',
                ],
            ],
            'SOUS_COLLINE'               => [
                'rules'  => 'required|min_length[2]|max_length[255]',
                'errors' => [
                    'required'   => 'La sous-colline/quartier est obligatoire',
                    'min_length' => 'La sous-colline doit contenir au moins 2 caractères',
                    'max_length' => 'La sous-colline ne peut dépasser 255 caractères',
                ],
            ],
            'ANNEE_MISE_EN_SERVICE'      => [
                'rules'  => 'required|numeric|exact_length[4]|greater_than[1900]|less_than[2100]',
                'errors' => [
                    'required'     => 'L\'année de mise en service est obligatoire',
                    'numeric'      => 'L\'année doit être un nombre',
                    'exact_length' => 'L\'année doit comporter 4 chiffres',
                    'greater_than' => 'L\'année doit être supérieure à 1900',
                    'less_than'    => 'L\'année doit être inférieure à 2100',
                ],
            ],
            'LINEAIRE_RESEAU'            => [
                'rules'  => 'required|numeric|greater_than[0]',
                'errors' => [
                    'required'     => 'Le linéaire du réseau est obligatoire',
                    'numeric'      => 'Le linéaire doit être un nombre',
                    'greater_than' => 'Le linéaire doit être supérieur à 0',
                ],
            ],
            'EXECUTANT'                  => [
                'rules'  => 'required|min_length[2]|max_length[255]',
                'errors' => [
                    'required'   => 'L\'exécutant/constructeur est obligatoire',
                    'min_length' => 'L\'exécutant doit contenir au moins 2 caractères',
                    'max_length' => 'L\'exécutant ne peut dépasser 255 caractères',
                ],
            ],
            'MAITRE_OEUVRE'              => [
                'rules'  => 'required|min_length[2]|max_length[255]',
                'errors' => [
                    'required'   => 'Le maître d\'œuvre est obligatoire',
                    'min_length' => 'Le maître d\'œuvre doit contenir au moins 2 caractères',
                    'max_length' => 'Le maître d\'œuvre ne peut dépasser 255 caractères',
                ],
            ],
            'POPULATION_COMMUNE_INITIAL' => [
                'rules'  => 'required|numeric|greater_than_equal_to[0]',
                'errors' => [
                    'required'              => 'La population initiale de la commune est obligatoire',
                    'numeric'               => 'La population doit être un nombre',
                    'greater_than_equal_to' => 'La population doit être positive ou nulle',
                ],
            ],
            'POPULATION_DESSERVIE'       => [
                'rules'  => 'required|numeric|greater_than_equal_to[0]',
                'errors' => [
                    'required'              => 'La population desservie est obligatoire',
                    'numeric'               => 'La population doit être un nombre',
                    'greater_than_equal_to' => 'La population doit être positive ou nulle',
                ],
            ],
        ];

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

        // Vérifier les dépendances (population desservie <= population initiale)
        // if ($postData['POPULATION_DESSERVIE'] > $postData['POPULATION_COMMUNE_INITIAL']) {
        //     return $this->response->setJSON([
        //         'success' => false,
        //         'message' => 'Erreur de validation',
        //         'errors' => [
        //             'POPULATION_DESSERVIE' => 'La population desservie ne peut pas être supérieure à la population totale de la commune'
        //         ]
        //     ]);
        // }
        $db = db_connect();
        // Commencer une transaction
        $db->transBegin();

        try {
            // Préparer les données
            $data = [
                'NOM'                        => $postData['NOM'],
                'PROVINCE_ID'                => $postData['PROVINCE_ID'],
                'COMMUNE_ID'                 => $postData['COMMUNE_ID'],
                'ZONE_ID'                    => $postData['ZONE_ID'],
                'COLLINE_ID'                 => $postData['COLLINE_ID'],
                'SOUS_COLLINE'               => $postData['SOUS_COLLINE'],
                'ANNEE_MISE_EN_SERVICE'      => $postData['ANNEE_MISE_EN_SERVICE'],
                'LINEAIRE_RESEAU'            => $postData['LINEAIRE_RESEAU'],
                'EXECUTANT'                  => $postData['EXECUTANT'],
                'MAITRE_OEUVRE'              => $postData['MAITRE_OEUVRE'],
                'POPULATION_COMMUNE_INITIAL' => $postData['POPULATION_COMMUNE_INITIAL'],
                'POPULATION_DESSERVIE'       => $postData['POPULATION_DESSERVIE'],
                'USER_ID'                    => $this->session->get('userdata')['USER_ID'],
            ];

            // Déterminer s'il s'agit d'une modification ou d'un ajout
            $aepId = $this->request->getPost('aep_id');

            if ($aepId && ! empty($aepId)) {
                // MODIFICATION
                $data['DATE_MODIFICATION'] = date('Y-m-d H:i:s');

                $db->table('aep')
                    ->where('AEP_ID', $aepId)
                    ->update($data);

                $result  = $aepId;
                $message = 'AEP modifiée avec succès';

                // Journaliser l'action
                // $this->logAction('update', $aepId, $data);

            } else {
                // AJOUT
                // Générer un code unique
                // $data['CODE'] = $this->model->generateCode(
                //     $postData['PROVINCE_ID'],
                //     $postData['COMMUNE_ID']
                // );
                $data['DATE_CREATION'] = date('Y-m-d H:i:s');

                $db->table('aep')->insert($data);
                $result  = $db->insertID();
                $message = 'AEP ajoutée avec succès';

                // Journaliser l'action
                // $this->logAction('insert', $result, $data);
            }

            if ($result) {
                $db->transCommit();

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

            log_message('error', '[AEP] Erreur save: ' . $e->getMessage());
            log_message('error', '[AEP] Trace: ' . $e->getTraceAsString());

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Une erreur est survenue lors de l\'enregistrement: ' . $e->getMessage(),
            ]);
        }
    }
    /**
     * liste des aep
     *
     * @return json
     */
    public function getAepList(): mixed
    {
        $var_search      = ! empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
        $var_search      = str_replace("'", "\'", $var_search);
        $query_principal = "SELECT a.AEP_ID, a.CODE, a.NOM, concat(p.PROVINCE_NAME,'-', c.COMMUNE_NAME,'-', z.ZONE_NAME,'-', col.COLLINE_NAME,'-', a.SOUS_COLLINE) LOCALITE, a.ANNEE_MISE_EN_SERVICE, a.LINEAIRE_RESEAU, a.EXECUTANT, a.MAITRE_OEUVRE, a.POPULATION_COMMUNE_INITIAL, a.POPULATION_DESSERVIE FROM aep a LEFT JOIN provinces p ON p.PROVINCE_ID = a.PROVINCE_ID LEFT JOIN communes c ON c.COMMUNE_ID = a.COMMUNE_ID LEFT JOIN zones z ON z.ZONE_ID = a.ZONE_ID LEFT JOIN collines col ON col.COLLINE_ID = a.COLLINE_ID WHERE 1";

        $group    = "";
        $critaire = "";

        $limit = 'LIMIT 0,1000';
        if ($_POST['length'] != -1) {
            $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
        }
        $order_by     = '';
        $order_column = ['AEP_ID',
            'LOCALITE',
            'NOM',
            'CODE',
            'ANNEE_MISE_EN_SERVICE',
            'LINEAIRE_RESEAU',
            'EXECUTANT',
            'MAITRE_OEUVRE',
            'POPULATION_COMMUNE_INITIAL',
            'POPULATION_DESSERVIE'];
        if (isset($_POST['order'])) {
            if ($_POST['order']['0']['column'] != 0) {
                $order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY INFRA_ID DESC';
            }
        } else {
            $order_by = ' ORDER BY NOM DESC';
        }
        $search = ! empty($_POST['search']['value']) ? (" AND (NOM LIKE '%$var_search%' OR CODE LIKE '%$var_search%')") : '';

        $query_secondaire = $query_principal . '  ' . $critaire . ' ' . $search . ' ' . $group . ' ' . $order_by . '   ' . $limit;

        $query_filter = $query_principal . '  ' . $critaire . ' ' . $search . ' ' . $group;

        $fetch_captage = $this->model->datatable($query_secondaire);

        $data = [];
        $i    = 0;
        foreach ($fetch_captage as $row) {

            $i++;
            $sub_array   = [];
            $sub_array[] = $i;
            $sub_array[] = $row->LOCALITE;
            $sub_array[] = $row->NOM;
            $sub_array[] = $row->CODE;
            $sub_array[] = $row->ANNEE_MISE_EN_SERVICE;
            $sub_array[] = $row->LINEAIRE_RESEAU;
            $sub_array[] = $row->EXECUTANT;
            $sub_array[] = $row->MAITRE_OEUVRE;
            $sub_array[] = $row->POPULATION_COMMUNE_INITIAL;
            $sub_array[] = $row->POPULATION_DESSERVIE;
            $sub_array[] = '<span onclick="modifier(' . $row->AEP_ID . ')" class="text-center" style="cursor:mouce-pointer;"><i class="bi bi-pencil-square"></i></span>';
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
     * Récupérer une AEP pour modification
     */
    public function getAep($id)
    {
        if (! $this->request->isAJAX()) {
            return $this->response->setStatusCode(403);
        }

        $data = $this->model->getOne('aep', ['AEP_ID' => $id]);

        if ($data) {
            return $this->response->setJSON([
                'success' => true,
                'data'    => $data,
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'AEP non trouvée',
        ]);
    }
    /**
     * Sauvegarder un exploitant (Ajout ou Modification)
     */
    public function enregistrerExploitant()
    {
        // Vérifier si c'est une requête AJAX
        if (! $this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'Accès non autorisé',
            ]);
        }

        // Règles de validation
        $rules = [
            'ENOM'            => [
                'rules'  => 'required|min_length[2]|max_length[100]',
                'errors' => [
                    'required'   => 'Le nom est obligatoire',
                    'min_length' => 'Le nom doit contenir au moins 2 caractères',
                    'max_length' => 'Le nom ne peut dépasser 100 caractères',
                ],
            ],
            'PRENOM'          => [
                'rules'  => 'required|min_length[2]|max_length[100]',
                'errors' => [
                    'required'   => 'Le prénom est obligatoire',
                    'min_length' => 'Le prénom doit contenir au moins 2 caractères',
                    'max_length' => 'Le prénom ne peut dépasser 100 caractères',
                ],
            ],
            'IS_POINT_FOCAL'  => [
                'rules'  => 'required|in_list[0,1]',
                'errors' => [
                    'required' => 'Le statut point focal est obligatoire',
                    'in_list'  => 'La valeur doit être Oui ou Non',
                ],
            ],
            'EAEP_ID'         => [
                'rules'  => 'required|integer|is_not_unique[aep.AEP_ID]',
                'errors' => [
                    'required'      => 'L\'AEP est obligatoire',
                    'integer'       => 'AEP invalide',
                    'is_not_unique' => 'L\'AEP sélectionnée n\'existe pas',
                ],
            ],
            'TEL'             => [
                'rules'  => 'required|min_length[8]|max_length[30]',
                'errors' => [
                    'required'   => 'Le numéro de téléphone est obligatoire',
                    'min_length' => 'Le numéro doit contenir au moins 8 caractères',
                    'max_length' => 'Le numéro ne peut dépasser 30 caractères',
                ],
            ],
            'EMAIL'           => [
                'rules'  => 'permit_empty|valid_email|max_length[100]',
                'errors' => [
                    'valid_email' => 'Veuillez entrer un email valide',
                    'max_length'  => 'L\'email ne peut dépasser 100 caractères',
                ],
            ],
            'TYPE_EXPLOITANT' => [
                'rules'  => 'permit_empty|in_list[1,2]',
                'errors' => [
                    'in_list' => 'Le type doit être Gestionnaire ou ACSPE',
                ],
            ],
        ];

        // Valider les données
        if (! $this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors'  => $this->validator->getErrors(),
            ]);
        }
        $id = $this->request->getPost('id_exploitant');
        // Récupérer les données validées
        $postData = $this->request->getPost();
        $db       = db_connect();
        // Commencer une transaction
        $db->transBegin();

        try {
            // Préparer les données
            $data = [
                'NOM'             => strtoupper(trim($postData['ENOM'])),
                'PRENOM'          => ucwords(strtolower(trim($postData['PRENOM']))),
                'IS_POINT_FOCAL'  => $postData['IS_POINT_FOCAL'],
                'AEP_ID'          => $postData['EAEP_ID'],
                'PROVINCE_ID'     => $postData['EPROVINCE'],
                'COMMUNE_ID'      => $postData['ECOMMUNE'],
                'TEL'             => trim($postData['TEL']),
                'EMAIL'           => ! empty($postData['EMAIL']) ? strtolower(trim($postData['EMAIL'])) : null,
                'TYPE_EXPLOITANT' => ! empty($postData['TYPE_EXPLOITANT']) ? $postData['TYPE_EXPLOITANT'] : null,
                'USER_ID'         => $this->session->get('userdata')['USER_ID'],

            ];

            if ($id && ! empty($id)) {
                // MODIFICATION
                $this->model->updateData('aep_exploitant', ['ID_EXPLOITANT' => $id], $data);
                $result  = $id;
                $message = 'Exploitant modifié avec succès';

                // Journaliser l'action
                // $this->logAction('update', $id, $data);

            } else {
                // AJOUT
                $result  = $this->model->insertLastId('aep_exploitant', $data);
                $message = 'Exploitant ajouté avec succès';

                // Journaliser l'action
                // $this->logAction('insert', $result, $data);
            }

            if ($result) {
                $db->transCommit();

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

            log_message('error', '[Exploitant] Erreur save: ' . $e->getMessage());
            log_message('error', '[Exploitant] Trace: ' . $e->getTraceAsString());

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Une erreur est survenue lors de l\'enregistrement: ' . $e->getMessage(),
            ]);
        }
    }
    /**
     * Récupérer un exploitant pour modification
     */
    public function getExploitant($id)
    {
        if (! $this->request->isAJAX()) {
            return $this->response->setStatusCode(403);
        }

        $data = $this->model->getOne('aep_exploitant', ['ID_EXPLOITANT' => $id]);

        if ($data) {
            return $this->response->setJSON([
                'success' => true,
                'data'    => $data,
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Exploitant non trouvé',
        ]);
    }
    /**
     * liste des exploitants d'une AEP
     *
     * @return json
     */
    public function exploitantList(): mixed
    {
        $var_search      = ! empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
        $var_search      = str_replace("'", "\'", $var_search);
        $query_principal = "SELECT ID_EXPLOITANT, CONCAT(e.`NOM`, ' ', `PRENOM`) NOM, ( CASE WHEN `TYPE_EXPLOITANT` = 1 THEN 'Gestionnaire' ELSE 'ACSPE' END ) TYPEE, `IS_POINT_FOCAL`, `TEL`, `EMAIL`, a.NOM AEP FROM `aep_exploitant` e JOIN aep a ON e.AEP_ID = a.AEP_ID WHERE 1";

        $group    = "";
        $critaire = "";

        $limit = 'LIMIT 0,1000';
        if ($_POST['length'] != -1) {
            $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
        }
        $order_by     = '';
        $order_column = ['ID_EXPLOITANT',
            'a.NOM',
            'TYPE_EXPLOITANT',
            'e.NOM',
            'TEL',
            'ID_EXPLOITANT'];
        if (isset($_POST['order'])) {
            if ($_POST['order']['0']['column'] != 0) {
                $order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY ID_EXPLOITANT DESC';
            }
        } else {
            $order_by = ' ORDER BY ID_EXPLOITANT DESC';
        }
        $search = ! empty($_POST['search']['value']) ? (" AND (e.NOM LIKE '%$var_search%' OR e.PRENOM LIKE '%$var_search%' OR a.NOM LIKE '%$var_search%')") : '';

        $query_secondaire = $query_principal . '  ' . $critaire . ' ' . $search . ' ' . $group . ' ' . $order_by . '   ' . $limit;

        $query_filter = $query_principal . '  ' . $critaire . ' ' . $search . ' ' . $group;

        $fetch_captage = $this->model->datatable($query_secondaire);

        $data = [];
        $i    = 0;
        foreach ($fetch_captage as $row) {

            $i++;
            $sub_array   = [];
            $sub_array[] = $i;
            $sub_array[] = $row->AEP;
            $sub_array[] = $row->TYPEE;
            $sub_array[] = $row->NOM;
            $sub_array[] = $row->TEL . "/" . $row->EMAIL;

            $sub_array[] = '<span onclick="modifierExploitant(' . $row->ID_EXPLOITANT . ')" class="text-center" style="cursor:mouce-pointer;"><i class="bi bi-pencil-square"></i></span>';
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
    public function createTypeDocument()
    {
        if (! $this->request->isAJAX()) {
            return $this->response->setStatusCode(403);
        }

        $json        = $this->request->getJSON();
        $description = trim($json->description ?? '');

        if (empty($description)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'La description est requise',
            ]);
        }

        if (strlen($description) < 3) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'La description doit contenir au moins 3 caractères',
            ]);
        }
        $db = db_connect();
        // Vérifier si le type existe déjà
        $exists = $db->table('aep_type_document')
            ->where('TYPE_DOCUMENT_DESCR', $description)
            ->countAllResults();

        if ($exists) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Ce type de document existe déjà',
            ]);
        }

        // Insérer le nouveau type
        $data = [
            'TYPE_DOCUMENT_DESCR' => $description,
        ];

        $db->table('aep_type_document')->insert($data);
        $newId = $db->insertID();

        return $this->response->setJSON([
            'success' => true,
            'data'    => [
                'TYPE_DOCUMENT_ID'    => $newId,
                'TYPE_DOCUMENT_DESCR' => $description,
            ],
        ]);
    }

    /**
     * Uploader des documents
     */
    public function enregistrerArchive()
    {
        // Vérifier si c'est une requête AJAX
        if (! $this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'Accès non autorisé',
            ]);
        }

        // Règles de validation
        $rules = [
            'TYPE_DOCUMENT_ID' => [
                'rules'  => 'required|integer',
                'errors' => [
                    'required' => 'Le type de document est obligatoire',
                    'integer'  => 'Type de document invalide',
                ],
            ],

            'AEP_ID'           => [
                'rules'  => 'required|integer|is_not_unique[aep.AEP_ID]',
                'errors' => [
                    'required'      => 'L\'AEP est obligatoire',
                    'integer'       => 'AEP invalide',
                    'is_not_unique' => 'L\'AEP sélectionnée n\'existe pas',
                ],
            ],
        ];

        // Valider les données
        if (! $this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors'  => $this->validator->getErrors(),
            ]);
        }

        // Récupérer les fichiers
        $files = $this->request->getFiles();

        if (empty($files['documents'])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Aucun document sélectionné',
            ]);
        }

        $documents = $files['documents'];

        // Vérifier le nombre de fichiers
        if (count($documents) > 10) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Vous ne pouvez pas uploader plus de 10 fichiers à la fois',
            ]);
        }
        // Définir le chemin d'upload
        $uploadPath = WRITEPATH . '/uploads/aep_archives/';
        $db         = db_connect();

        // Créer le dossier s'il n'existe pas
        if (! is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }
        // Commencer une transaction
        $db->transBegin();

        try {
            $uploadedFiles = [];
            $errors        = [];

            foreach ($documents as $file) {
                // Vérifier si le fichier est valide
                if (! $file->isValid()) {
                    $errors[] = 'Fichier invalide: ' . $file->getErrorString();
                    continue;
                }

                // Vérifier la taille (5MB max)
                if ($file->getSize() > 5 * 1024 * 1024) {
                    $errors[] = 'Le fichier ' . $file->getName() . ' dépasse 5MB';
                    continue;
                }

                // Vérifier le type MIME
                $allowedTypes = [
                    'application/pdf',
                    'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'application/vnd.ms-excel',
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'image/jpeg',
                    'image/png',
                    'image/gif',
                    'text/plain',
                ];

                if (! in_array($file->getMimeType(), $allowedTypes)) {
                    $errors[] = 'Type de fichier non autorisé: ' . $file->getName();
                    continue;
                }

                // Générer un nom unique
                $newName = $file->getRandomName();

                // Déplacer le fichier
                if ($file->move($uploadPath, $newName)) {
                    // Préparer les données pour la base
                    $data = [
                        'TYPE_DOCUMENT_ID'    => $this->request->getPost('TYPE_DOCUMENT_ID'),
                        'PATH_DOCUMENT'       => 'uploads/aep_archives/' . $newName,
                        'USER_ID'             => $this->session->get('userdata')['USER_ID'],
                        'AEP_ID'              => $this->request->getPost('AEP_ID'),
                        'PROVINCE_ID'         => $this->request->getPost('PROVINCE_ID'),
                        'COMMUNE_ID'          => $this->request->getPost('COMMUNE_ID'),
                        'DESCRIPTION'         => $this->request->getPost('DESCRIPTION'),
                        'NOM_ORIGINAL'        => $file->getClientName(),
                        'DATE_ENREGISTREMENT' => date('Y-m-d H:i:s'),
                    ];

                    $insertID        = $this->model->insertLastId('aep_archives', $data);
                    $uploadedFiles[] = [
                        'id'  => $insertID,
                        'nom' => $file->getClientName(),
                    ];
                } else {
                    $errors[] = 'Erreur lors de l\'upload de ' . $file->getName();
                }
            }

            if (empty($uploadedFiles)) {
                throw new \Exception('Aucun fichier n\'a pu être uploadé');
            }

            $db->transCommit();
            $message = count($uploadedFiles) . ' fichier(s) uploadé(s) avec succès';
            if (! empty($errors)) {
                $message .= ' mais ' . count($errors) . ' erreur(s) : ' . implode(', ', $errors);
            }

            return $this->response->setJSON([
                'success'  => true,
                'message'  => $message,
                'uploaded' => $uploadedFiles,
                'errors'   => $errors,
            ]);

        } catch (\Exception $e) {
            $db->transRollback();

            // Supprimer les fichiers uploadés en cas d'erreur
            foreach ($uploadedFiles ?? [] as $file) {
                $path = $uploadPath . basename($file['nom']);
                if (file_exists($path)) {
                    unlink($path);
                }
            }

            log_message('error', '[Archive] Erreur upload: ' . $e->getMessage());

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Une erreur est survenue lors de l\'upload: ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Supprimer une archive
     */
    public function deleteArchive($id)
    {
        if (! $this->request->isAJAX()) {
            return $this->response->setStatusCode(403);
        }

        try {
            // Récupérer l'archive pour obtenir le chemin du fichier
            $archive = $this->model->getOne('aep_archives', ['ID_ARCHIVE' => $id]);
            // Supprimer le fichier physique
            $filePath = WRITEPATH . $archive['PATH_DOCUMENT'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // Supprimer de la base de données
            $this->model->deleteData('aep_archives', ['ID_ARCHIVE' => $id]);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Document supprimé avec succès',
            ]);

        } catch (\Exception $e) {
            log_message('error', '[Archive] Erreur delete: ' . $e->getMessage());

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Erreur lors de la suppression',
            ]);
        }
    }
    /**
     * liste des archives d'une AEP
     *
     * @return json
     */
    public function archiveList(): mixed
    {
        $var_search      = ! empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
        $var_search      = str_replace("'", "\'", $var_search);
        $query_principal = "SELECT ID_ARCHIVE, a.NOM,d.TYPE_DOCUMENT_DESCR,`NOM_ORIGINAL`, PATH_DOCUMENT, DATE_ENREGISTREMENT FROM `aep_archives` ar JOIN aep a ON ar.AEP_ID=a.AEP_ID JOIN aep_type_document d ON ar.TYPE_DOCUMENT_ID=d.TYPE_DOCUMENT_ID WHERE 1";

        $group = "";

        $critaire = "";

        $limit = 'LIMIT 0,1000';
        if ($_POST['length'] != -1) {
            $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
        }
        $order_by     = '';
        $order_column = ['ID_ARCHIVE',
            'a.NOM',
            'TYPE_DOCUMENT_DESCR',
            'NOM_ORIGINAL',
            'ID_ARCHIVE'];
        if (isset($_POST['order'])) {
            if ($_POST['order']['0']['column'] != 0) {
                $order_by = isset($_POST['order']) ? ' ORDER BY ' . $order_column[$_POST['order']['0']['column']] . '  ' . $_POST['order']['0']['dir'] : ' ORDER BY ID_ARCHIVE DESC';
            }
        } else {
            $order_by = ' ORDER BY ID_ARCHIVE DESC';
        }
        $search = ! empty($_POST['search']['value']) ? (" AND (a.NOM LIKE '%$var_search%')") : '';

        $query_secondaire = $query_principal . '  ' . $critaire . ' ' . $search . ' ' . $group . ' ' . $order_by . '   ' . $limit;

        $query_filter = $query_principal . '  ' . $critaire . ' ' . $search . ' ' . $group;

        $fetch_archive = $this->model->datatable($query_secondaire);

        $data = [];
        $i    = 0;
        foreach ($fetch_archive as $row) {

            $i++;
            $sub_array   = [];
            $sub_array[] = $i;
            $sub_array[] = $row->NOM;
            $sub_array[] = $row->TYPE_DOCUMENT_DESCR;
            $sub_array[] = '<a href="' . base_url('infrastructure/download_archive/' . $row->ID_ARCHIVE) . '"
                style="color: #0d6efd; text-decoration: none; display: flex; align-items: center; gap: 8px;">
                <i class="bi bi-file-earmark" style="font-size: 1.2rem;"></i>
                <span style="border-bottom: 1px dashed #0d6efd;">' . $row->NOM_ORIGINAL . '</span>
                </a>';

            $sub_array[] = '<span onclick="deleteArchive(' . $row->ID_ARCHIVE . ')" class="text-center" style="cursor:mouce-pointer;"><i class="bi bi-trash"></i></span>';
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
    public function downloadArchive($ID_ARCHIVE)
    {
        $archive = $this->model->getOne('aep_archives', ['ID_ARCHIVE' => $ID_ARCHIVE]);

        if (! $archive) {
            return redirect()->back()->with('error', 'Document non trouvé');
        }

        // Si PATH_DOCUMENT contient "uploads/aep_archives/nom_fichier.pdf"
        $filePath = WRITEPATH . $archive['PATH_DOCUMENT'];

        if (! file_exists($filePath)) {
            return redirect()->back()->with('error', 'Fichier non trouvé');
        }

        return $this->response->download($filePath, null)
            ->setFileName($archive['NOM_ORIGINAL']);
    }
}
