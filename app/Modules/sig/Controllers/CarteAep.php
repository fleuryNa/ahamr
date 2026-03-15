<?php

namespace App\Modules\Sig\Controllers;

use App\Controllers\BaseController;

class CarteAep extends BaseController
{
    public function index()
    {
        return view('App\Modules\Sig\Views\CarteAepView');
    }

    public function data()
    {
        $province = $this->request->getGet('province');
        $commune  = $this->request->getGet('commune');

        $sql = "SELECT 
                    i.INFRA_ID,
                    a.AEP_ID,
                    a.CODE AS aep_code,
                    a.NOM AS aep_nom,
                    a.EXECUTANT,

                    a.PROVINCE_ID,
                    a.COMMUNE_ID,
                    p.PROVINCE_NAME AS province,
                    c.COMMUNE_NAME AS commune,

                    i.TYPE_INFRA_ID,
                    t.DESCRIPTION AS type_infra,

                    i.LAT AS lat,
                    i.LONG AS lng,

                    parent.CODE AS parent_code,
                    parent.NOM AS parent_nom,

                    ip.LAT AS parent_lat,
                    ip.LONG AS parent_lng

                FROM aep a

                LEFT JOIN provinces p 
                    ON p.PROVINCE_ID = a.PROVINCE_ID

                LEFT JOIN communes c 
                    ON c.COMMUNE_ID = a.COMMUNE_ID

                LEFT JOIN (
                    SELECT ai1.*
                    FROM aep_infrastructures ai1
                    INNER JOIN (
                        SELECT CODE, MIN(INFRA_ID) AS min_infra_id
                        FROM aep_infrastructures
                        GROUP BY CODE
                    ) ai2 ON ai1.INFRA_ID = ai2.min_infra_id
                ) i ON i.CODE = a.CODE

                LEFT JOIN type_infrastructure t 
                    ON t.TYPE_AEP_ID = i.TYPE_INFRA_ID

                LEFT JOIN aep parent 
                    ON parent.CODE = a.EXECUTANT

                LEFT JOIN (
                    SELECT ai1.*
                    FROM aep_infrastructures ai1
                    INNER JOIN (
                        SELECT CODE, MIN(INFRA_ID) AS min_infra_id
                        FROM aep_infrastructures
                        GROUP BY CODE
                    ) ai2 ON ai1.INFRA_ID = ai2.min_infra_id
                ) ip ON ip.CODE = parent.CODE

                WHERE i.LAT IS NOT NULL 
                AND i.LONG IS NOT NULL";

        if (!empty($province)) {
            $province = addslashes($province);
            $sql .= " AND a.PROVINCE_ID = '" . $province . "'";
        }

        if (!empty($commune)) {
            $commune = addslashes($commune);
            $sql .= " AND a.COMMUNE_ID = '" . $commune . "'";
        }

        $sql .= " ORDER BY a.AEP_ID ASC";

        $rows = $this->model->getRequete($sql);

        $points = [];

        foreach ($rows as $r) {
            $lat = str_replace(',', '.', $r['lat'] ?? '');
            $lng = str_replace(',', '.', $r['lng'] ?? '');
            $parentLat = str_replace(',', '.', $r['parent_lat'] ?? '');
            $parentLng = str_replace(',', '.', $r['parent_lng'] ?? '');

            if (!is_numeric($lat) || !is_numeric($lng)) {
                continue;
            }

            $points[] = [
                "id" => $r["INFRA_ID"] ?? null,
                "aep_id" => $r["AEP_ID"] ?? null,
                "aep_code" => $r["aep_code"] ?? '',
                "aep_nom" => $r["aep_nom"] ?? '',
                "province_id" => $r["PROVINCE_ID"] ?? null,
                "commune_id" => $r["COMMUNE_ID"] ?? null,
                "province" => $r["province"] ?? '',
                "commune" => $r["commune"] ?? '',
                "type_infra_id" => $r["TYPE_INFRA_ID"] ?? null,
                "type_infra" => $r["type_infra"] ?? '',
                "parent_code" => $r["parent_code"] ?? '',
                "parent_nom" => $r["parent_nom"] ?? '',
                "lat" => (float)$lat,
                "lng" => (float)$lng,
                "parent_lat" => is_numeric($parentLat) ? (float)$parentLat : null,
                "parent_lng" => is_numeric($parentLng) ? (float)$parentLng : null
            ];
        }

        return $this->response->setJSON($points);
    }
}

?>