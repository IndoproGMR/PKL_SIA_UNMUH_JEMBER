<?php

namespace App\Models;

use CodeIgniter\Model;

class Quary extends Model
{
    // protected $DBGroup          = 'default';
    protected $table            = 'test_quary';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    // protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name',
        'email',
        'gender',
        'waktu'
    ];

    function countdb()
    {
        return $this->countAllResults();
    }

    function cariquary($cari, $order = null, $datatambahan = null)
    {
        if (empty($order)) {
            return $this
                ->like('name', $cari)
                ->orLike('email', $cari)
                ->orLike('gender', $cari)
                ->orLike('waktu', $cari)
                ->find();
        }
        if (!empty($datatambahan)) {
            $datatambahan = $datatambahan . ' AND ';
        }
        $db = \Config\Database::connect("siautama", false);
        $sql = "SELECT * FROM `test_quary` WHERE " .
            $db->escapeLikeString($datatambahan) . " (`name` LIKE '%" .
            $db->escapeLikeString($cari) . "%' ESCAPE '!' OR `email` LIKE '%" .
            $db->escapeLikeString($cari) . "%' ESCAPE '!' OR `gender` LIKE '%" .
            $db->escapeLikeString($cari) . "%' ESCAPE '!' OR `waktu` LIKE '%" .
            $db->escapeLikeString($cari) . "%' ESCAPE '!') " .
            $db->escapeLikeString($order); //tambah limit
        // return $query->getResult();
        // echo "cariquary";
        // echo $sql;
        return $db->query($sql)->getResult('array');

        // $data = $this->like('name', $cari)->find();
        // return $data;
    }

    function orderquary($order = null, $datatambahan = null)
    {
        if (!empty($datatambahan)) {
            $datatambahan = " WHERE " . $datatambahan . " ";
        }
        $db = \Config\Database::connect();
        $sql = "SELECT * FROM `test_quary` " . $db->escapeLikeString($datatambahan) . $db->escapeLikeString($order);
        // echo "orderquary";
        echo $sql;
        return $db->query($sql)->getResult('array');
    }
}

// TODO:
// bagaimana cara nya supaya bisa order by dan juga membatasi waktu

// SELECT * FROM `test_quary` WHERE `name` LIKE '%ac%' ESCAPE '!' OR `email` LIKE '%ac%' ESCAPE '!' OR `gender` LIKE '%ac%' ESCAPE '!' OR `waktu` LIKE '%ac%' ESCAPE '!' ORDER BY `name` ASC AND waktu > 1562744465000;

// SELECT * FROM `test_quary`WHERE `waktu` >1562744465000 ORDER BY `test_quary`.`name` ASC

//SELECT * FROM `test_quary` WHERE `name` LIKE '%a%' ESCAPE '!' OR `email` LIKE '%a%' ESCAPE '!' AND waktu > 100778948400000 ORDER BY `test_quary`.`waktu` ASC;

//SELECT * FROM `test_quary` WHERE (`name` LIKE '%a%' ESCAPE '!' OR `email` LIKE '%a%' ESCAPE '!') AND waktu > 100778948400000 ORDER BY `test_quary`.`waktu`  ASC;

// -order:gender_ASC-waktu>1000
// -order:gender_ASC---waktu>--1000
// -order:gender_ASC-1 or 1--waktu>--1000

//-order:waktu_ASC->waktu AND ('1or1')--