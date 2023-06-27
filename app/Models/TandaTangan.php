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

    function cekvalidasi($nosurat, $data)
    {
        $data = $this
            ->select('SM_ttd.NoSurat,SM_ttd.TimeStamp,SM_ttd.pendattg_id,SM_ttd_SuratMasuk.mshw_id,SM_JenisSurat.name as jenisSurat')
            ->join('SM_ttd_SuratMasuk', 'SM_ttd_SuratMasuk.NoSurat = SM_ttd.NoSurat')
            ->join('SM_JenisSurat', 'SM_JenisSurat.id = SM_ttd_SuratMasuk.JenisSurat_id')
            ->where('SM_ttd.NoSurat', $nosurat)
            ->where('SM_ttd.hash', $data)
            ->find();

        if (count($data) > 0) {
            return $data[0];
        } else {
            helper('datacall');

            $data = [
                'NoSurat'     => datacallRespond('e'),
                'TimeStamp'   => datacallRespond('e'),
                'pendattg_id' => datacallRespond('e'),
                'mshw_id'     => datacallRespond('e'),
                'jenisSurat'  => datacallRespond('e'),
                'valid'       => 'TTD0'
            ];
            return $data;
        }
    }


    function cekStatusById($id)
    {
        // return $this->where('status',$id)->find($id);
        return $this
            ->select('SM_ttd.Status,SM_ttd_SuratMasuk.mshw_id,SM_ttd.NoSurat')
            ->join('SM_ttd_SuratMasuk', 'SM_ttd_SuratMasuk.NoSurat=SM_ttd.NoSurat')
            ->where('SM_ttd.id', $id)
            ->find()[0];
    }

    function addTTD($isidata)
    {
        // masukan array
        return $this->insertBatch($isidata);
    }

    function updateTTD($id, $data)
    {
        return $this->update($id, $data);
    }

    // untuk melihat berapa banyak yang sudah ttd dan belum // (2/10)
    function cekStatusSurat($nosurat)
    {
        $data['totalTTD'] = $this
            ->where('NoSurat', $nosurat)
            ->countAllResults();

        $data['belum'] = $this
            ->where('NoSurat', $nosurat)
            ->where('status', '0')
            ->countAllResults();

        $data['sudah'] = $this
            ->where('NoSurat', $nosurat)
            ->where('status', '1')
            ->countAllResults();

        return $data;
    }

    // untuk melihat semua ttd yang sudah dan belum di TTD kan 
    function cekStatusSuratTTD($pendattg_id)
    {
        $db = \Config\Database::connect();

        $sql = "SELECT `SM_ttd`.`id` AS idttd,`SM_ttd`.`Status`,`SM_ttd`.`NoSurat`,`SM_ttd`.`pendattg_id`,`SM_JenisSurat`.`name` as namaJenisSurat,`SM_ttd_SuratMasuk`.`TimeStamp`,`SM_ttd`.`jenisttd` 
        FROM `SM_ttd` 
        LEFT JOIN `SM_ttd_SuratMasuk` ON `SM_ttd_SuratMasuk`.`NoSurat` = `SM_ttd`.`NoSurat` 
        LEFT JOIN `SM_JenisSurat` ON `SM_JenisSurat`.`id`=`SM_ttd_SuratMasuk`.`JenisSurat_id` 
        WHERE `SM_ttd`.`Status` = '0' and (`SM_ttd`.`pendattg_id` = '" .
            $db->escapeLikeString($pendattg_id['id']) . "' OR `SM_ttd`.`pendattg_id` = '" .
            $db->escapeLikeString($pendattg_id['namaLVL']) . "' );";

        return $db->query($sql)->getResult('array');
    }
}


// SELECT * FROM `SM_ttd`
// WHERE `NoSurat` = 'DveUCIo1' 
// AND 
// ( `pendattg_id` = '0014027501'
//     OR    `pendattg_id` = 'Dosen')
// ORDER BY `SM_ttd`.`Status` ASC;



// SELECT * FROM `SM_ttd`
// WHERE (`SM_ttd`.`pendattg_id` = '0014027501'
//     OR
//     `SM_ttd`.`pendattg_id` = 'Dosen' )
//     LEFT JOIN `SM_ttd_SuratMasuk`
//     ON `SM_ttd_SuratMasuk`.`NoSurat` = `SM_ttd`.`NoSurat`


// SELECT * FROM `SM_ttd`
//     LEFT JOIN `SM_ttd_SuratMasuk`
//     ON `SM_ttd_SuratMasuk`.`NoSurat` = `SM_ttd`.`NoSurat`
//     WHERE (`SM_ttd`.`pendattg_id` = '0014027501'
//     OR
//     `SM_ttd`.`pendattg_id` = 'Dosen' );



// SELECT `SM_ttd`.`id` AS idttd,`SM_ttd`.`Status`,`SM_ttd`.`NoSurat`,`SM_ttd`.`NoSurat`,`SM_ttd`.`pendattg_id`

// FROM `SM_ttd` 

// LEFT JOIN `SM_ttd_SuratMasuk` 

// ON `SM_ttd_SuratMasuk`.`NoSurat` = `SM_ttd`.`NoSurat` 

// WHERE (`SM_ttd`.`pendattg_id` = '0001016602' 
//        OR `SM_ttd`.`pendattg_id` = 'Dosen' );




// SELECT `SM_ttd`.`id` AS idttd,`SM_ttd`.`Status`,`SM_ttd`.`NoSurat`,`SM_ttd`.`pendattg_id`,`SM_JenisSurat`.`name`,`SM_ttd_SuratMasuk`.`TimeStamp`,`SM_ttd`.`jenisttd`
// FROM `SM_ttd` 
// LEFT JOIN `SM_ttd_SuratMasuk` 
// ON `SM_ttd_SuratMasuk`.`NoSurat` = `SM_ttd`.`NoSurat`
// LEFT JOIN `SM_JenisSurat`
// ON `SM_JenisSurat`.`id`=`SM_ttd_SuratMasuk`.`JenisSurat_id`
// WHERE (`SM_ttd`.`pendattg_id` = '0001016602' 
//        OR `SM_ttd`.`pendattg_id` = 'Dosen' );

// SELECT `SM_ttd`.`id` AS idttd,`SM_ttd`.`Status`,`SM_ttd`.`NoSurat`,`SM_ttd`.`pendattg_id`,`SM_JenisSurat`.`name`,`SM_ttd_SuratMasuk`.`TimeStamp`,`SM_ttd`.`jenisttd` FROM `SM_ttd` LEFT JOIN `SM_ttd_SuratMasuk` ON `SM_ttd_SuratMasuk`.`NoSurat` = `SM_ttd`.`NoSurat` LEFT JOIN `SM_JenisSurat` ON `SM_JenisSurat`.`id`=`SM_ttd_SuratMasuk`.`JenisSurat_id` WHERE (`SM_ttd`.`pendattg_id` = '0001016602' OR `SM_ttd`.`pendattg_id` = 'Dosen' );