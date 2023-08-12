<?php

namespace App\Models;

use CodeIgniter\Model;

class SuratMasukModel extends Model
{
    // protected $DBGroup          = 'default';
    protected $table            = 'SM_SuratArchice';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    // protected $returnType       = 'array';
    // protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'DiskirpsiSurat',
        'NomerSurat',
        'TanggalSurat',
        'DataSurat',
        'NamaFile',
        'JenisSuratArchice_id',
        'TimeStamp',
        'DeleteAt'
    ];

    public function seeallbyJenis($idJenis = 'all')
    {
        if ($idJenis == 'all') {
            return $this
                ->select('
                SM_SuratArchice.id as idSurat,
                SM_JenisSuratArchice.Name as JenisSurat,
                SM_SuratArchice.DiskirpsiSurat as DiskripsiSurat,
                SM_SuratArchice.NomerSurat as NoSurat,
                SM_SuratArchice.TanggalSurat as TanggalSurat,
                ')
                ->join('SM_JenisSuratArchice', 'SM_JenisSuratArchice.id=SM_SuratArchice.JenisSuratArchice_id')
                ->findAll();
            // return $this->findAll();
        }
        return $this
            ->select('
            SM_SuratArchice.id as idSurat,
            SM_JenisSuratArchice.Name as JenisSurat,
            SM_SuratArchice.DiskirpsiSurat as DiskripsiSurat,
            SM_SuratArchice.NomerSurat as NoSurat,
            SM_SuratArchice.TanggalSurat as TanggalSurat,
            ')
            ->join('SM_JenisSuratArchice', 'SM_JenisSuratArchice.id=SM_SuratArchice.JenisSuratArchice_id')
            ->where('JenisSuratArchice_id', $idJenis)
            ->findAll();
        // return $this->where('JenisSuratArchice_id', $idJenis)->findAll();
    }

    function addSuratMasuk($data)
    {
        return $this->save($data);
    }
}
