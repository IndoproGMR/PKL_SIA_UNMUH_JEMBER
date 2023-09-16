<?php

namespace App\Models;

use CodeIgniter\Model;

class TandaTangan extends Model
{
    // protected $DBGroup          = 'default';
    protected $table            = 'SK_ttd';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    // protected $returnType       = 'array';
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
            ->select('SK_ttd.Status,SK_ttd_SuratMasuk.mshw_id,SK_ttd_SuratMasuk.NoSurat')
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

        // !old query
        // $data['totalTTD'] = $this
        //     ->where('NoSurat', $nosurat)
        //     ->countAllResults();

        // $data['belum'] = $this
        //     ->where('NoSurat', $nosurat)
        //     ->where('status', '0')
        //     ->countAllResults();

        // $data['sudah'] = $this
        //     ->where('NoSurat', $nosurat)
        //     ->where('status', '1')
        //     ->countAllResults();

        // return $data;

        /**
         *SELECT
         *COUNT(*) AS total,
         *SUM(CASE WHEN Status = 1 THEN 1 ELSE 0 END) AS dataTrue,
         *SUM(CASE WHEN Status = 0 THEN 1 ELSE 0 END) AS dataFalse
         *FROM
         *    SK_ttd
         *GROUP BY
         *    NoSurat;
         *
         */
    }

    // untuk melihat semua ttd yang sudah dan belum di TTD kan untuk penandatangan
    function cekStatusSuratTTD($pendattg_id, $status = 0)
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
            ->where('`SK_ttd_SuratMasuk`.`NoSurat` != ', 'Belum_Memiliki_No_Surat')
            ->where('SK_ttd_SuratMasuk.DeleteAt', null)
            ->groupStart()
            ->where('`SK_ttd`.`pendattg_id`', $pendattg_id['id'])
            ->orWhere('`SK_ttd`.`pendattg_id`', $pendattg_id['namaLVL'])
            ->groupEnd()
            ->find();

        // d($data);
        return $data;

        // $db = \Config\Database::connect();

        // $sql = "SELECT `SK_ttd`.`id` AS idttd,`SK_ttd`.`Status`,`SK_ttd`.`NoSurat`,`SK_ttd`.`pendattg_id`,`SK_JenisSurat`.`name` as namaJenisSurat,`SK_ttd_SuratMasuk`.`TimeStamp`,`SK_ttd`.`jenisttd` ,`SK_ttd`.`TimeStamp` as `TimeStamp_ttd`
        // FROM `SK_ttd` 
        // LEFT JOIN `SK_ttd_SuratMasuk` ON `SK_ttd_SuratMasuk`.`NoSurat` = `SK_ttd`.`NoSurat` 
        // LEFT JOIN `SK_JenisSurat` ON `SK_JenisSurat`.`id`=`SK_ttd_SuratMasuk`.`JenisSurat_id` 
        // WHERE `SK_ttd`.`Status` = '" . $status . "' and 
        // (`SK_ttd`.`pendattg_id` = '" .
        //     $db->escapeLikeString($pendattg_id['id']) .
        //     "' OR `SK_ttd`.`pendattg_id` = '" .
        //     $db->escapeLikeString($pendattg_id['namaLVL']) .
        //     "' );";

        // return $db->query($sql)->getResult('array');
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