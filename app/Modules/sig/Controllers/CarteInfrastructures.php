<?php

namespace App\Modules\Sig\Controllers;

use App\Controllers\BaseController;

class CarteInfrastructures extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Carte Infrastructure (SIG)',
        ];

        // On charge la vue du module via le chemin complet
        return view('App\Modules\sig\Views\CarteInfrastructuresView', $data);
    }

    /**
     * Endpoint JSON: retourne les infrastructures (points) pour Leaflet
     * URL exemple: /sig/carteinfrastructures/points
     */
    public function points()
    {
        // print_r("ok");
        $sql = "SELECT i.INFRA_ID, i.CODE, i.NOM, i.AEP, i.ETAT_ID, i.OBSERVATION, i.LAT, i.`LONG`, CASE WHEN i.FONCTIONNALITE_ID = 1 THEN 'Fonctionnel' WHEN i.FONCTIONNALITE_ID = 2 THEN 'Non fonctionnel' ELSE 'Non renseigné' END AS FONCTIONNALITE_ID, e.DESCRIPTION AS ETAT_LIBELLE, t.DESCRIPTION AS TYPE_INFRA_LIBELLE, m.DESCRIPTION AS MATERIEL_LIBELLE, p.PROVINCE_ID, p.PROVINCE_NAME, c.COMMUNE_ID, c.COMMUNE_NAME FROM aep_infrastructures i LEFT JOIN aep_etat e ON e.ETAT_ID = i.ETAT_ID LEFT JOIN type_infrastructure t ON t.TYPE_AEP_ID = i.TYPE_INFRA_ID LEFT JOIN aep_type_materiel m ON m.TYPE_MATERIEL_ID = i.MATERIEL_TYPE_ID LEFT JOIN provinces p ON i.PROVINCE = p.PROVINCE_ID LEFT JOIN communes c ON i.COMMUNE = c.COMMUNE_ID WHERE i.LAT IS NOT NULL AND i.LAT <> '' AND i.`LONG` IS NOT NULL AND i.`LONG` <> ''";

        $rows = $this->model->getRequete($sql);

        $points = array_values(array_filter(array_map(function ($r) {
            $lat = str_replace(',', '.', (string)($r['LAT'] ?? ''));
            $lng = str_replace(',', '.', (string)($r['LONG'] ?? ''));

            $latF = is_numeric($lat) ? (float)$lat : null;
            $lngF = is_numeric($lng) ? (float)$lng : null;

            if ($latF === null || $lngF === null) {
                return null;
            }

            return [
                'id' => (int)$r['INFRA_ID'],
                'code' => $r['CODE'] ?? '',
                'nom' => $r['NOM'] ?? '',
                'aep' => $r['AEP'] ?? '',
                'etat_id' => $r['ETAT_ID'] ?? null,
                'etat' => $r['ETAT_LIBELLE'] ?? '',
                'observation' => $r['OBSERVATION'] ?? '',
                'lat' => $latF,
                'lng' => $lngF,
                'materiel_type_id' => $r['MATERIEL_TYPE_ID'] ?? null,
                'materiel' => $r['MATERIEL_LIBELLE'] ?? '',
                'type_infra_id' => $r['TYPE_INFRA_ID'] ?? null,
                'type_infra' => $r['TYPE_INFRA_LIBELLE'] ?? '',
                'fonctionnalite_id' => $r['FONCTIONNALITE_ID'] ?? null,
                'province' => $r['PROVINCE_NAME'] ?? null,
                'commune' => $r['COMMUNE_NAME'] ?? null,
            ];
        }, $rows)));

        return $this->response->setJSON($points);
    }

}