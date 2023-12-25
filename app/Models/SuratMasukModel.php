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
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'DiskirpsiSurat',
        'NomerSurat',
        'TanggalSurat',
        'DataSurat',
        'NamaFile',
        'JenisSuratArchice_id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];


    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';


    public function seebyid($id)
    {
        // return $this->find($id);
        return $this->select('
        SM_SuratArchice.DiskirpsiSurat,
        SM_SuratArchice.NomerSurat,
        SM_SuratArchice.DataSurat,
        SM_SuratArchice.TanggalSurat,
        SM_SuratArchice.DiskirpsiSurat,
        SM_SuratArchice.created_at as TimeStamp,
        SM_SuratArchice.JenisSuratArchice_id,
        SM_JenisSuratArchice.name,
        SM_SuratArchice.NamaFile
        ')
            ->join('SM_JenisSuratArchice', 'SM_JenisSuratArchice.id=SM_SuratArchice.JenisSuratArchice_id', 'left')
            ->find($id);
    }

    public function seefilebyid($id)
    {
        // return $this->find($id);
        return $this->select('SM_SuratArchice.NamaFile')->find($id)['NamaFile'];
    }

    function deleteSuratMasuk($id)
    {
        return $this->delete($id);
    }


    public function seeallbyFilter($idJenis = 'all', $TextF = null, $dateS = null, $dateE = null, $limit = 10)
    {
        $build = $this->select('
        SM_SuratArchice.id as idSurat,
        SM_JenisSuratArchice.Name as JenisSurat,
        SM_SuratArchice.DiskirpsiSurat as DiskripsiSurat,
        SM_SuratArchice.NomerSurat as NoSurat,
        SM_SuratArchice.TanggalSurat as TanggalSurat,
        ')
            ->join('SM_JenisSuratArchice', 'SM_JenisSuratArchice.id=SM_SuratArchice.JenisSuratArchice_id')
            ->orderBy('SM_SuratArchice.created_at', 'DESC');


        if (!is_null($dateS)) {
            // $dateS = $dateS . " 00:00:01";
            $textquery = 'SM_SuratArchice.TanggalSurat BETWEEN "' . $dateS . '"';

            if (!is_null($dateE)) {
                $dateE = '"' . $dateE . '"';
            } else {
                helper('textsurat');
                $dateE = '"' . getDateTime('date') . '"';
            }

            $textquery = $textquery . " AND " . $dateE;

            $build->groupStart()
                ->where($textquery)
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

        return $build->findAll($limit);
    }

    function seeAllNoJenisSuratID()
    {
        return $this->select('
        SM_SuratArchice.id as idSurat,
        SM_SuratArchice.DiskirpsiSurat as DiskripsiSurat,
        SM_SuratArchice.NomerSurat as NoSurat,
        SM_SuratArchice.TanggalSurat as TanggalSurat,
        ')
            // ->join('SM_JenisSuratArchice', 'SM_JenisSuratArchice.id=SM_SuratArchice.JenisSuratArchice_id')
            ->orderBy('SM_SuratArchice.updated_at', 'DESC')
            ->where('SM_SuratArchice.JenisSuratArchice_id', 0)->findAll();
    }

    function addSuratMasuk($data)
    {
        $data['id'] = generateIdentifier();
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

    // !delete
    function SeeDel()
    {
        return $this->where('deleted_at !=', null)->withDeleted()->findAll();
    }
}
