<?php

namespace App\Models;

use CodeIgniter\Model;

class TandaTangan extends Model
{
    // protected $DBGroup          = 'default';
    protected $table            = 'SK_ttd';
    protected $primaryKey       = 'id';
    // protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'SuratIdentifier',
        'Status',
        'hash',
        'qrcodeName',
        'jenisttd',
        'pendattg_id',
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

    function cekNotifPerluTTD()
    {
        $pendattg_id = userInfo();
        return $this
            ->select('count("*") as total')
            ->join('SK_ttd_MintaSurat', '`SK_ttd_MintaSurat`.`SuratIdentifier` = `SK_ttd`.`SuratIdentifier`')
            // ->join('SK_MasterSurat', '`SK_MasterSurat`.`id`=`SK_ttd_MintaSurat`.`MasterSurat_id`')
            ->where('`SK_ttd`.`Status`', 0)
            ->where('`SK_ttd_MintaSurat`.`Status`', 0)
            ->where('`SK_ttd_MintaSurat`.`NoSurat` != ', 'Belum_Memiliki_No_Surat')
            ->where('SK_ttd_MintaSurat.deleted_at', null)
            ->groupStart()
            ->where('`SK_ttd`.`pendattg_id`', $pendattg_id['id'])
            ->orWhere('`SK_ttd`.`pendattg_id`', $pendattg_id['namaLVL'])
            ->groupEnd()
            ->findAll()[0]['total'];
    }


    function seeallbyIdenti($Identi)
    {
        return $this
            ->where('SuratIdentifier', $Identi)
            ->where('Status', 1)
            ->findAll();
    }


    function cekvalidasi($nosurat, $data)
    {
        $data = $this
            ->select('
            SK_ttd_MintaSurat.NoSurat,
            SK_ttd.updated_at as TimeStamp,
            SK_ttd.pendattg_id,
            SK_ttd_MintaSurat.mshw_id,
            SK_MasterSurat.name as jenisSurat')
            ->join('SK_ttd_MintaSurat', 'SK_ttd_MintaSurat.SuratIdentifier = SK_ttd.SuratIdentifier')
            ->join('SK_MasterSurat', 'SK_MasterSurat.id = SK_ttd_MintaSurat.MasterSurat_id')
            ->where('SK_ttd_MintaSurat.NoSurat', $nosurat)
            ->where('SK_ttd.hash', $data)
            ->find();

        if (count($data) > 0) {
            return $data[0];
        } else {
            $data = [
                'NoSurat'     => 'e',
                'updated_at'   => 'e',
                'pendattg_id' => 'e',
                'mshw_id'     => 'e',
                'jenisSurat'  => 'e',
                'valid'       => 'TTD.n.exist.db'
            ];
            return $data;
        }
    }


    function cekStatusById($id)
    {
        // return $this->where('status',$id)->find($id);
        return $this
            ->select('
                SK_ttd.Status,
                SK_ttd_MintaSurat.mshw_id,
                SK_ttd_MintaSurat.NoSurat
            ')
            ->join('SK_ttd_MintaSurat', 'SK_ttd_MintaSurat.SuratIdentifier=SK_ttd.SuratIdentifier')
            ->where('SK_ttd.id', $id)
            ->find()[0];
    }

    function addTTD($isidata)
    {
        // masukan array
        // return $this->insertBatch($isidata);
        return $this->db->table('SK_ttd')->insertBatch($isidata);
    }

    function updateTTD($id, $data)
    {
        // masukan array
        return $this->update($id, $data);
    }




    // untuk melihat berapa banyak yang sudah ttd dan belum // (2/10)
    function cekStatusSurat($SuratIdentifier)
    {
        $datautama = $this
            ->select('COUNT(*) AS totalTTD,
                SUM(CASE WHEN Status = 1 THEN 1 ELSE 0 END) AS sudah,
                SUM(CASE WHEN Status = 0 THEN 1 ELSE 0 END) AS belum')
            ->where('SuratIdentifier', $SuratIdentifier)
            ->find();

        if (count($datautama) == 1) {
            return $datautama[0];
        }

        $data['totalTTD'] = 99;
        $data['sudah'] = 0;
        $data['belum'] = 99;
        return $data;
    }

    // untuk melihat semua ttd yang sudah dan belum di TTD kan untuk penandatangan
    function cekStatusSuratTTD($pendattg_id, $status = 0, $jenisSurat = 'all', $search = null, $dateS = null, $dateE = null, $limit = 10)
    {
        $data = $this
            ->select('
                `SK_ttd`.`id` AS idttd,
                `SK_ttd`.`Status`,
                `SK_ttd_MintaSurat`.`NoSurat`,
                `SK_ttd`.`SuratIdentifier`,
                `SK_ttd`.`pendattg_id`,
                `SK_MasterSurat`.`name` as namaJenisSurat,
                `SK_ttd_MintaSurat`.`created_at`,
                `SK_ttd`.`jenisttd` ,
                `SK_ttd`.`updated_at` as `TimeStamp_ttd`')

            ->join('SK_ttd_MintaSurat', '`SK_ttd_MintaSurat`.`SuratIdentifier` = `SK_ttd`.`SuratIdentifier`')
            ->join('SK_MasterSurat', '`SK_MasterSurat`.`id`=`SK_ttd_MintaSurat`.`MasterSurat_id`')

            ->where('SK_ttd.Status', $status)
            ->where('SK_ttd_MintaSurat.deleted_at', null)
            ->where('SK_ttd_MintaSurat.Status', 0)
            ->where('SK_ttd_MintaSurat.NoSurat != ', 'Belum_Memiliki_No_Surat')

            ->groupStart()
            ->where('`SK_ttd`.`pendattg_id`', $pendattg_id['id'])
            ->orWhere('`SK_ttd`.`pendattg_id`', $pendattg_id['namaLVL'])
            ->groupEnd()
            ->orderBy('SK_ttd_MintaSurat.created_at', 'DESC');

        if (!is_null($search)) {
            $data->groupStart()
                ->like('`SK_ttd_MintaSurat`.`NoSurat`', $search)
                ->orLike('`SK_ttd_MintaSurat`.`mshw_id`', $search)
                ->groupEnd();
        }

        if ($jenisSurat !== 'all') {
            $data->groupStart()
                ->where('SK_ttd_MintaSurat.MasterSurat_id', $jenisSurat)
                ->groupEnd();
        }

        if (!is_null($dateS)) {
            $dateS = $dateS . " 00:00:01";
            $textquery = 'SK_ttd_MintaSurat.created_at BETWEEN "' . $dateS . '"';

            if (!is_null($dateE)) {
                $dateE = '"' . $dateE . " 23:59:59" . '"';
            } else {
                helper('textsurat');
                $dateE = '"' . getDateTime() . '"';
            }

            $textquery = $textquery . " AND " . $dateE;

            $data->groupStart()
                ->where($textquery)
                ->groupEnd();
        }


        $data = $data
            ->findAll($limit);

        // d($data);

        return $data;
    }

    function cekStatusSuratTTDCount($pendattg_id, $status = 0)
    {
        return $this
            ->select('count("*") as total')
            ->join('SK_ttd_MintaSurat', '`SK_ttd_MintaSurat`.`SuratIdentifier` = `SK_ttd`.`SuratIdentifier`')
            ->join('SK_MasterSurat', '`SK_MasterSurat`.`id`=`SK_ttd_MintaSurat`.`MasterSurat_id`')
            ->where('`SK_ttd`.`Status`', $status)
            ->where('`SK_ttd_MintaSurat`.`NoSurat` != ', 'Belum_Memiliki_No_Surat')
            ->where('SK_ttd_MintaSurat.deleted_at', null)
            ->groupStart()
            ->where('`SK_ttd`.`pendattg_id`', $pendattg_id['id'])
            ->orWhere('`SK_ttd`.`pendattg_id`', $pendattg_id['namaLVL'])
            ->groupEnd()
            ->findAll()[0]['total'];
    }
}
