<?php

namespace App\Models;

use CodeIgniter\Model;

class Suratmasuk extends Model
{
    // protected $DBGroup          = 'default';
    protected $table            = 'SM_ttd_SuratMasuk';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    // protected $returnType       = 'array';
    // protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'NoSurat',
        'DataTambahan',
        'TimeStamp',
        'JenisSurat_id',
        'mshw_id'
    ];

    function addSuratMasuk($data)
    {
        return $this->save($data);
        // return $this->where('NoSurat', $data['NoSurat'])->find()[0]['id'];
    }

    function cekNoSurat(string $iduser)
    {
        return $this
            ->select('SM_JenisSurat.name as namaJenisSurat,SM_ttd_SuratMasuk.NoSurat,SM_ttd_SuratMasuk.TimeStamp')
            ->where('mshw_id', $iduser)
            ->join('SM_JenisSurat', 'SM_JenisSurat.id=SM_ttd_SuratMasuk.JenisSurat_id')
            ->find();
    }
}
