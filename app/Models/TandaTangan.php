<?php

namespace App\Models;

use CodeIgniter\Model;

class TandaTangan extends Model
{
    // protected $DBGroup          = 'default';
    protected $table            = 'SK_ttd';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    // protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'Status',
        'NoSurat',
        'SuratIdentifier',
        'hash',
        'qrcodeName',
        'jenisttd',
        'pendattg_id',
        'TimeStamp',
    ];

    function seeallbyIdenti($Identi)
    {
        return $this->where('SuratIdentifier', $Identi)->findAll();
    }


    function cekvalidasi($nosurat, $data)
    {
        $data = $this
            ->select('
            SK_ttd_SuratMasuk.NoSurat,
            SK_ttd.TimeStamp,
            SK_ttd.pendattg_id,
            SK_ttd_SuratMasuk.mshw_id,
            SK_JenisSurat.name as jenisSurat')
            ->join('SK_ttd_SuratMasuk', 'SK_ttd_SuratMasuk.SuratIdentifier = SK_ttd.SuratIdentifier')
            ->join('SK_JenisSurat', 'SK_JenisSurat.id = SK_ttd_SuratMasuk.JenisSurat_id')
            ->where('SK_ttd_SuratMasuk.NoSurat', $nosurat)
            ->where('SK_ttd.hash', $data)
            ->find();

        if (count($data) > 0) {
            return $data[0];
        } else {
            $data = [
                'NoSurat'     => 'e',
                'TimeStamp'   => 'e',
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
                SK_ttd_SuratMasuk.mshw_id,
                SK_ttd_SuratMasuk.NoSurat
            ')
            ->join('SK_ttd_SuratMasuk', 'SK_ttd_SuratMasuk.SuratIdentifier=SK_ttd.SuratIdentifier')
            ->where('SK_ttd.id', $id)
            ->find()[0];
    }

    function addTTD($isidata)
    {
        // masukan array
        return $this->insertBatch($isidata);
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
    function cekStatusSuratTTD($pendattg_id, $status = 0, $jenisSurat = 'all', $search = null, $time = 1)
    {
        $data = $this
            ->select('
                `SK_ttd`.`id` AS idttd,
                `SK_ttd`.`Status`,
                `SK_ttd_SuratMasuk`.`NoSurat`,
                `SK_ttd`.`SuratIdentifier`,
                `SK_ttd`.`pendattg_id`,
                `SK_JenisSurat`.`name` as namaJenisSurat,
                `SK_ttd_SuratMasuk`.`TimeStamp`,
                `SK_ttd`.`jenisttd` ,
                `SK_ttd`.`TimeStamp` as `TimeStamp_ttd`')

            ->join('SK_ttd_SuratMasuk', '`SK_ttd_SuratMasuk`.`SuratIdentifier` = `SK_ttd`.`SuratIdentifier`')
            ->join('SK_JenisSurat', '`SK_JenisSurat`.`id`=`SK_ttd_SuratMasuk`.`JenisSurat_id`')

            ->where('`SK_ttd`.`Status`', $status)
            ->where('SK_ttd_SuratMasuk.DeleteAt', null)
            ->where('`SK_ttd_SuratMasuk`.`NoSurat` != ', 'Belum_Memiliki_No_Surat')

            ->groupStart()
            ->where('`SK_ttd`.`pendattg_id`', $pendattg_id['id'])
            ->orWhere('`SK_ttd`.`pendattg_id`', $pendattg_id['namaLVL'])
            ->groupEnd()
            ->orderBy('SK_ttd_SuratMasuk.TimeStamp', 'DESC');

        if (!is_null($search)) {
            $data->groupStart()
                ->like('`SK_ttd_SuratMasuk`.`NoSurat`', $search)
                ->orLike('`SK_ttd_SuratMasuk`.`mshw_id`', $search)
                ->groupEnd();
        }

        if ($jenisSurat !== 'all') {
            $data->groupStart()
                ->where('SK_ttd_SuratMasuk.JenisSurat_id', $jenisSurat)
                ->groupEnd();
        }

        if ($time !== 'all' && is_null($search)) {
            $timeNow = getUnixTimeStamp();

            $timeAtas  = $timeNow - (2592000 * ($time));
            $timeBawah = $timeNow - (2592000 * ($time - 1));

            $data->groupStart()
                ->where('SK_ttd_SuratMasuk.TimeStamp >=', $timeAtas)
                ->where('SK_ttd_SuratMasuk.TimeStamp <=', $timeBawah)
                ->groupEnd();
        }

        $data = $data
            ->findAll(100);

        return $data;
    }

    function cekStatusSuratTTDCount($pendattg_id, $status = 0)
    {
        return $this
            ->select('count("*") as total')
            ->join('SK_ttd_SuratMasuk', '`SK_ttd_SuratMasuk`.`SuratIdentifier` = `SK_ttd`.`SuratIdentifier`')
            ->join('SK_JenisSurat', '`SK_JenisSurat`.`id`=`SK_ttd_SuratMasuk`.`JenisSurat_id`')
            ->where('`SK_ttd`.`Status`', $status)
            ->where('`SK_ttd_SuratMasuk`.`NoSurat` != ', 'Belum_Memiliki_No_Surat')
            ->where('SK_ttd_SuratMasuk.DeleteAt', null)
            ->groupStart()
            ->where('`SK_ttd`.`pendattg_id`', $pendattg_id['id'])
            ->orWhere('`SK_ttd`.`pendattg_id`', $pendattg_id['namaLVL'])
            ->groupEnd()
            ->findAll()[0]['total'];
    }
}


// SELECT * FROM `SK_ttd`
// WHERE `NoSurat` = 'DveUCIo1' 
// AND 
// ( `pendattg_id` = '0014027501'
//     OR    `pendattg_id` = 'Dosen')
// ORDER BY `SK_ttd`.`Status` ASC;



// SELECT * FROM `SK_ttd`
// WHERE (`SK_ttd`.`pendattg_id` = '0014027501'
//     OR
//     `SK_ttd`.`pendattg_id` = 'Dosen' )
//     LEFT JOIN `SK_ttd_SuratMasuk`
//     ON `SK_ttd_SuratMasuk`.`NoSurat` = `SK_ttd`.`NoSurat`


// SELECT * FROM `SK_ttd`
//     LEFT JOIN `SK_ttd_SuratMasuk`
//     ON `SK_ttd_SuratMasuk`.`NoSurat` = `SK_ttd`.`NoSurat`
//     WHERE (`SK_ttd`.`pendattg_id` = '0014027501'
//     OR
//     `SK_ttd`.`pendattg_id` = 'Dosen' );



// SELECT `SK_ttd`.`id` AS idttd,`SK_ttd`.`Status`,`SK_ttd`.`NoSurat`,`SK_ttd`.`NoSurat`,`SK_ttd`.`pendattg_id`

// FROM `SK_ttd` 

// LEFT JOIN `SK_ttd_SuratMasuk` 

// ON `SK_ttd_SuratMasuk`.`NoSurat` = `SK_ttd`.`NoSurat` 

// WHERE (`SK_ttd`.`pendattg_id` = '0001016602' 
//        OR `SK_ttd`.`pendattg_id` = 'Dosen' );




// SELECT `SK_ttd`.`id` AS idttd,`SK_ttd`.`Status`,`SK_ttd`.`NoSurat`,`SK_ttd`.`pendattg_id`,`SK_JenisSurat`.`name`,`SK_ttd_SuratMasuk`.`TimeStamp`,`SK_ttd`.`jenisttd`
// FROM `SK_ttd` 
// LEFT JOIN `SK_ttd_SuratMasuk` 
// ON `SK_ttd_SuratMasuk`.`NoSurat` = `SK_ttd`.`NoSurat`
// LEFT JOIN `SK_JenisSurat`
// ON `SK_JenisSurat`.`id`=`SK_ttd_SuratMasuk`.`JenisSurat_id`
// WHERE (`SK_ttd`.`pendattg_id` = '0001016602' 
//        OR `SK_ttd`.`pendattg_id` = 'Dosen' );

// SELECT `SK_ttd`.`id` AS idttd,`SK_ttd`.`Status`,`SK_ttd`.`NoSurat`,`SK_ttd`.`pendattg_id`,`SK_JenisSurat`.`name`,`SK_ttd_SuratMasuk`.`TimeStamp`,`SK_ttd`.`jenisttd` FROM `SK_ttd` LEFT JOIN `SK_ttd_SuratMasuk` ON `SK_ttd_SuratMasuk`.`NoSurat` = `SK_ttd`.`NoSurat` LEFT JOIN `SK_JenisSurat` ON `SK_JenisSurat`.`id`=`SK_ttd_SuratMasuk`.`JenisSurat_id` WHERE (`SK_ttd`.`pendattg_id` = '0001016602' OR `SK_ttd`.`pendattg_id` = 'Dosen' );