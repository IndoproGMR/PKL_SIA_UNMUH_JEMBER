<?php

namespace App\Models;

use CodeIgniter\Model;

class SuratMasukModel extends Model
{
    // protected $DBGroup          = 'default';
    protected $table            = 'SM_SuratArchice';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
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
        'TimeStampUpdate',
        'DeleteAt'
    ];

    public function seebyid($id)
    {
        // return $this->find($id);
        return $this->select('
        SM_SuratArchice.DiskirpsiSurat,
        SM_SuratArchice.NomerSurat,
        SM_SuratArchice.DataSurat,
        SM_SuratArchice.TanggalSurat,
        SM_SuratArchice.DiskirpsiSurat,
        SM_SuratArchice.TimeStamp,
        SM_SuratArchice.JenisSuratArchice_id,
        SM_JenisSuratArchice.name,
        SM_SuratArchice.NamaFile
        ')
            ->join('SM_JenisSuratArchice', 'SM_JenisSuratArchice.id=SM_SuratArchice.JenisSuratArchice_id')
            ->find($id);
    }

    public function seefilebyid($id)
    {
        // return $this->find($id);
        return $this->select('SM_SuratArchice.NamaFile')->find($id)['NamaFile'];
    }

    function deleteSuratMasuk($id)
    {
        $data = [
            'DeleteAt' => getUnixTimeStamp()
        ];
        return $this->update($id, $data);
    }


    public function seeallbyFilter($idJenis = 'all', $TanggalSurat = null, $TextF = null)
    {
        $build = $this->select('
        SM_SuratArchice.id as idSurat,
        SM_JenisSuratArchice.Name as JenisSurat,
        SM_SuratArchice.DiskirpsiSurat as DiskripsiSurat,
        SM_SuratArchice.NomerSurat as NoSurat,
        SM_SuratArchice.TanggalSurat as TanggalSurat,
        ')
            ->join('SM_JenisSuratArchice', 'SM_JenisSuratArchice.id=SM_SuratArchice.JenisSuratArchice_id')
            ->where('SM_SuratArchice.DeleteAt', null)
            ->orderBy('SM_SuratArchice.TimeStamp', 'DESC');


        if (!is_null($TanggalSurat)) {
            $build
                ->groupStart()
                ->where('SM_SuratArchice.TanggalSurat', $TanggalSurat)
                ->groupEnd();
        }

        if (!is_null($TextF)) {
            $build
                ->groupStart()
                ->Like('SM_SuratArchice.DiskirpsiSurat', $TextF)
                ->orlike('SM_SuratArchice.NomerSurat', $TextF)
                ->orLike('SM_SuratArchice.DataSurat', $TextF)
                ->groupEnd();
        }


        if ($idJenis !== 'all') {
            return $build
                ->where('JenisSuratArchice_id', $idJenis)
                ->findAll();
        }

        return $build->findAll(100);
    }



    function addSuratMasuk($data)
    {
        $data['id'] = generateIdentifier();
        d($data);
        return $this->db->table('SM_SuratArchice')->insert($data);
    }

    function updateSuratMasuk($id, $data)
    {
        return $this->update($id, $data);
    }

    function setdeletejenisSuratMasuk($idjenisSurat)
    {
        return $this
            ->where('JenisSuratArchice_id', $idjenisSurat)
            ->set(['JenisSuratArchice_id' => 0])
            ->update();
    }
}
