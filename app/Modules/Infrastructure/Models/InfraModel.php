<?php
namespace App\Modules\Infrastructure\Models;

use CodeIgniter\Model;

class AhamrModel extends Model
{
    //make_datatables : requete avec Condition,LIMIT start,length
    public function datatable($requete)
    {
        $query = $this->db->query($requete); //call function make query
        return $query->getResult();
    }
    public function getRequete($requete)
    {
        $query = $this->db->query($requete); //call function make query
        return $query->getResultArray();
    }

    public function maker($requete)
    {
        return $this->db->query($requete);
    }
    //count_all_data : requete sans Condition sans LIMIT start,length
    public function all_data($requete)
    {
        $query = $this->maker($requete); //call function make query
        return $query->getNumRows();
    }

    public function create($table, $data)
    {
        return $this->db->table($table)->insert($data);
    }

    public function inserBatch($table, $data)
    {
        $query = $this->db->table($table)->insertBatch($data);
        return ($query) ? true : false;
    }
    public function updateDataBatch($table, $data, $idField)
    {
        $query = $this->db->table($table)->updateBatch($data, $idField);
        return ($query) ? true : false;
    }
    public function insertLastId($table, $data)
    {
        $query = $this->db->table($table)->insert($data);

        if ($query) {
            return $this->db->insertID();
        }
    }
    public function getList($table, $criteres = [], $order_by = null, $order_direction = 'ASC')
    {
        $builder = $this->db->table($table)->where($criteres);

        // Appliquer l'ordre si spécifié
        if ($order_by !== null) {
            $builder->orderBy($order_by, $order_direction);
        }

        $query = $builder->get();
        return $query->getResult();
    }

    public function getOne($table, $criteres)
    {
        $query = $this->db->table($table)->where($criteres)->get();
        return $query->getRowArray();
    }
    public function deleteData($table, $criteres)
    {

        $query = $this->db->table($table)->delete($criteres);
        return ($query) ? true : false;
    }
    public function getRequeteOne($requete)
    {
        $query = $this->db->query($requete);
        if ($query) {
            return $query->getRowArray();
        }
    }
    public function updateData($table, $criteres, $data)
    {
        $query = $this->db->table($table)->update($data, $criteres);
        return ($query) ? true : false;
    }

}
