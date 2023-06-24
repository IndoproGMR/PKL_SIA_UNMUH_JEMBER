<?php

namespace App\Models;

use CodeIgniter\Model;

class TandaTangan extends Model
{
    // protected $DBGroup          = 'default';
    protected $table            = 'SM_ttd';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    // protected $returnType       = 'array';
    // protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'Status',
        'hash',
        'RandomStr',
        'TimeStamp',
        'NoSurat',
        'jenisttd',
        'pendattg_id',
    ];

    function addTTD($isidata)
    {
        // masukan array
        return $this->insertBatch($isidata);
    }

    function cekStatusSurat($nosurat)
    {
        $data['totalTTD'] = $this->where('NoSurat', $nosurat)->countAllResults();
        $data['belum'] = $this->where('NoSurat', $nosurat)->where('status', '0')->countAllResults();
        $data['sudah'] = $this->where('NoSurat', $nosurat)->where('status', '1')->countAllResults();

        return $data;
    }
}
