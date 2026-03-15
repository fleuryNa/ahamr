<?php

namespace App\Modules\Sig\Controllers;

use App\Controllers\BaseController;

class CarteMaintenance extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Carte Maintenance (SIG)',
        ];

        // On charge la vue du module via le chemin complet
        return view('App\Modules\sig\Views\CarteMaintenanceView', $data);
    }

    /**
     * Endpoint JSON: retourne les maintenance(points) pour Leaflet
     * URL exemple: /sig/cartemaintenance/points
     */
    public function data()
    {
        $sql = "SELECT 
                    m.MAINTENANCE_ID,
                    provinces.PROVINCE_NAME AS province,
                    communes.COMMUNE_NAME AS commune,

                    aep.CODE AS aep_code,
                    aep.NOM AS aep_nom,

                    m.PHOTO AS photo,
                    m.STATUT_ID AS statut_id,
                    m.ETAT_ID AS etat_id,
                    eta.DESCRIPTION AS etat_description,

                    CONCAT(rh_users.NOM, ' ', rh_users.PRENOM) AS user,
                    CONCAT(val.NOM, ' ', val.PRENOM) AS validateur,
                    DATE_FORMAT(m.DATE_ENREGISTREMENT, '%d/%m/%Y') AS date_enregistrement,
                    DATE_FORMAT(m.DATE_MAINTENANCE, '%d/%m/%Y') AS date_maintenance,
                    DATE_FORMAT(m.DATE_MODIFICATION, '%d/%m/%Y') AS date_modification,

                    -- m.DATE_ENREGISTREMENT AS date_enregistrement,
                    -- m.DATE_MAINTENANCE AS date_maintenance,
                    m.COMMENTAIRE AS commentaire,
                    -- m.DATE_MODIFICATION AS date_modification,
                    m.OBSERVATION_VALIDATION AS observation_validation,

                    typ.TYPE_AEP_ID AS type_infra_id,
                    typ.DESCRIPTION AS type_infra_description,

                    i.LAT AS lat,
                    i.LONG AS lng

                FROM maintenance m
                LEFT JOIN aep ON aep.AEP_ID = m.AEP_ID
                LEFT JOIN provinces ON provinces.PROVINCE_ID = m.PROVINCE_ID
                LEFT JOIN communes ON communes.COMMUNE_ID = m.COMMUNE_ID
                LEFT JOIN aep_etat eta ON eta.ETAT_ID = m.ETAT_ID
                LEFT JOIN rh_users ON rh_users.USER_ID = m.USER_ID
                LEFT JOIN rh_users val ON val.USER_ID = m.USER_VALIDATEUR
                LEFT JOIN (
                    SELECT ai1.*
                    FROM aep_infrastructures ai1
                    INNER JOIN (
                        SELECT CODE, MIN(INFRA_ID) AS min_infra_id
                        FROM aep_infrastructures
                        GROUP BY CODE
                    ) ai2 ON ai1.INFRA_ID = ai2.min_infra_id
                ) i ON i.CODE = aep.CODE
                LEFT JOIN type_infrastructure typ ON typ.TYPE_AEP_ID = i.TYPE_INFRA_ID";

        $rows = $this->model->getRequete($sql);

        $points = array_values(array_filter(array_map(function ($r) {

            $lat = str_replace(',', '.', (string)($r['lat'] ?? ''));
            $lng = str_replace(',', '.', (string)($r['lng'] ?? ''));

            $latF = is_numeric($lat) ? (float)$lat : null;
            $lngF = is_numeric($lng) ? (float)$lng : null;

            if ($latF === null || $lngF === null) {
                return null;
            }

            return [
                'id' => (int)($r['MAINTENANCE_ID'] ?? 0),

                'province' => $r['province'] ?? '',
                'commune' => $r['commune'] ?? '',

                'aep_code' => $r['aep_code'] ?? '',
                'aep_nom' => $r['aep_nom'] ?? '',

                'etat_id' => $r['etat_id'] ?? null,
                'etat_description' => $r['etat_description'] ?? '',

                'photo' => $r['photo'] ?? '',
                'statut_id' => $r['statut_id'] ?? null,

                'user' => $r['user'] ?? '',
                'validateur' => $r['validateur'] ?? '',

                'date_enregistrement' => $r['date_enregistrement'] ?? null,
                'date_maintenance' => $r['date_maintenance'] ?? null,
                'date_modification' => $r['date_modification'] ?? null,

                'commentaire' => $r['commentaire'] ?? '',
                'observation_validation' => $r['observation_validation'] ?? '',

                'type_infra_id' => $r['type_infra_id'] ?? null,
                'type_infra_description' => $r['type_infra_description'] ?? '',

                'lat' => $latF,
                'lng' => $lngF
            ];

        }, $rows)));

        return $this->response->setJSON($points);
    }

}
?>