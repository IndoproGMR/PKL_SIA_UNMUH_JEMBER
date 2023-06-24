<?php

namespace App\Models;

use CodeIgniter\Model;

class AuthUserGroup extends Model
{
    // protected $DBGroup          = 'siautama';
    protected $table            = 'level';
    protected $primaryKey       = 'LevelID';
    // protected $useAutoIncrement = true;
    // protected $returnType       = 'array';
    // protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'MhswID',
        'Password',
        'LevelID'
    ];



    function proseslogin($datalogin, $datapassword)
    {
        $db = \Config\Database::connect("siautama", false);
        $sql = "SELECT `level`.`Nama` as namaLVL 
        FROM `level` 
        LEFT JOIN `mhsw` ON `level`.`LevelID`=`mhsw`.`LevelID` 
        LEFT JOIN `dosen` on `level`.`LevelID`=`dosen`.`LevelID` 
        LEFT JOIN `karyawan` ON `level`.`LevelID`=`karyawan`.`LevelID` 
        WHERE (`mhsw`.`Login` = '" .
            $db->escapeLikeString($datalogin) .
            "' AND `mhsw`.`Password`='" .
            $db->escapeLikeString($datapassword) . "') 
        OR (`dosen`.`Login`='" .
            $db->escapeLikeString($datalogin) .
            "' AND `dosen`.`Password`='" .
            $db->escapeLikeString($datapassword) . "') 
        OR (`karyawan`.`Login`='" .
            $db->escapeLikeString($datalogin) .
            "' AND `karyawan`.`Password`='" .
            $db->escapeLikeString($datapassword) . "');";
        $hasil = $db->query($sql)->getResultArray();
        if (count($hasil) == 1) {
            return true;
        }
        return false;
    }

    function cekuserinfo($iduser)
    {
        $db = \Config\Database::connect("siautama", false);
        $sql = "SELECT `level`.`Nama` AS namaLVL, 
        COALESCE(`mhsw`.`Nama`, `dosen`.`Nama`, `karyawan`.`Nama`) AS NamaUser, 
        COALESCE(`mhsw`.`Login`, `dosen`.`Login`, `karyawan`.`Login`) AS LoginUser, 
        COALESCE(`mhsw`.`Foto`,`level`.`Simbol`) AS FotoUser 
        FROM `level` 
        LEFT JOIN `mhsw` ON `level`.`LevelID` = `mhsw`.`LevelID` 
        LEFT JOIN `dosen` ON `level`.`LevelID` = `dosen`.`LevelID` 
        LEFT JOIN `karyawan` ON `level`.`LevelID` = `karyawan`.`LevelID` 
        WHERE 
        (`mhsw`.`Login` = '" . $db->escapeLikeString($iduser) . "' 
        OR `dosen`.`Login` = '" . $db->escapeLikeString($iduser) . "' 
        OR `karyawan`.`Login` = '" . $db->escapeLikeString($iduser) . "');";
        return $db->query($sql)->getResultArray()[0];
    }
}

// ! mahasiswa
// SELECT `level`.`Nama`,`mhsw`.`Nama` ,`mhsw`.`Login`,`mhsw`.`Password` FROM `level` LEFT JOIN `mhsw` ON `level`.`LevelID`=`mhsw`.`LevelID` WHERE `mhsw`.`Login` = '06123047' AND `level`.`Nama` ='Mahasiswa';

// TODO buat sistem login
// TODO cari tau apa itu jabatan
// TODO Cari tabel apa saja yang memiliki login dan password DONE
// ! ada 5 lvl
// !PMD tidak valid banyak yang null
// !dosen
// !karyawan
// !aplikasn
// !mhsw
// TODO gabung data login DONE


// ! dosen, karyawan, aplikasn, mhsw (info user)
// SELECT 
//     `level`.`Nama` AS namaLVL,
//     COALESCE(`mhsw`.`Nama`, `dosen`.`Nama`, `karyawan`.`Nama`, `aplikan`.`Nama`) AS NamaUser,
//     COALESCE(`mhsw`.`Login`, `dosen`.`Login`, `karyawan`.`Login`, `aplikan`.`Login`) AS LoginUser,
//     COALESCE(`mhsw`.`Foto`, `aplikan`.`Foto`,`level`.`Simbol`) AS FotoUser
// FROM `level`
// LEFT JOIN `mhsw` ON `level`.`LevelID` = `mhsw`.`LevelID`
// LEFT JOIN `dosen` ON `level`.`LevelID` = `dosen`.`LevelID`
// LEFT JOIN `karyawan` ON `level`.`LevelID` = `karyawan`.`LevelID`
// LEFT JOIN `aplikan` ON `level`.`LevelID` = `aplikan`.`LevelID`
// WHERE 
//     (`mhsw`.`Login` = '20110084' OR
//     `dosen`.`Login` = '20110084' OR
//     `karyawan`.`Login` = '20110084' OR
//     `aplikan`.`Login` = '20110084');



// ! dosen, karyawan, aplikasn, mhsw ()
// SELECT 
// `level`.`Nama` as namaLVL,
// `mhsw`.`Nama` as namaMHS,
// `mhsw`.`Login`,
// `mhsw`.`Password`,
// `dosen`.`Nama` as namaDOSEN,
// `dosen`.`Login`,
// `dosen`.`Password`,
// `karyawan`.`Nama` as namaKARYAWAN,
// `karyawan`.`Login`,
// `karyawan`.`Password`,
// `aplikan`.`Nama` as namaAPLIKAN,
// `aplikan`.`Login`,
// `aplikan`.`Password`
// FROM `level` 
// LEFT JOIN `mhsw` 
// ON `level`.`LevelID`=`mhsw`.`LevelID` 
// LEFT JOIN `dosen`
// on `level`.`LevelID`=`dosen`.`LevelID`
// LEFT JOIN `karyawan`
// ON `level`.`LevelID`=`karyawan`.`LevelID`
// LEFT JOIN `aplikan`
// ON `level`.`LevelID`= `aplikan`.`LevelID`
// WHERE `level`.`Nama` ='Dosen' AND 
// (`mhsw`.`Login` = '20110084' 
//  OR `dosen`.`Login`='20110084' 
//  OR `karyawan`.`Login`='20110084'
//  OR `aplikan`.`Login`='20110084');



// SELECT `level`.`Nama`, `mhsw`.`Nama` , `mhsw`.`Login`, `mhsw`.`Password`, `dosen`.`Nama`, `dosen`.`Login`, `dosen`.`Password`, `karyawan`.`Nama`, `karyawan`.`Login`, `karyawan`.`Password`, `aplikan`.`Nama`, `aplikan`.`Login`, `aplikan`.`Password` FROM `level` LEFT JOIN `mhsw` ON `level`.`LevelID`=`mhsw`.`LevelID` LEFT JOIN `dosen` on `level`.`LevelID`=`dosen`.`LevelID` LEFT JOIN `karyawan` ON `level`.`LevelID`=`karyawan`.`LevelID` LEFT JOIN `aplikan` ON `level`.`LevelID`= `aplikan`.`LevelID` WHERE `level`.`Nama` ='Dosen' AND (`mhsw`.`Login` = '20110084' OR `dosen`.`Login`='20110084' OR `karyawan`.`Login`='20110084' OR `aplikan`.`Login`='20110084');


// ! dosen, karyawan, aplikasn, mhsw (login) (idlogin,password)
// SELECT 
// `level`.`Nama` as namaLVL
// FROM `level` 
// LEFT JOIN `mhsw` 
// ON `level`.`LevelID`=`mhsw`.`LevelID` 
// LEFT JOIN `dosen`
// on `level`.`LevelID`=`dosen`.`LevelID`
// LEFT JOIN `karyawan`
// ON `level`.`LevelID`=`karyawan`.`LevelID`
// LEFT JOIN `aplikan`
// ON `level`.`LevelID`= `aplikan`.`LevelID`
// WHERE (`mhsw`.`Login` = 'yuni' AND `mhsw`.`Password`='*FDF3D0567')
//  OR (`dosen`.`Login`='yuni' AND `dosen`.`Password`='*FDF3D0567')
//  OR (`karyawan`.`Login`='yuni' AND `karyawan`.`Password`='*FDF3D0567')
//  OR (`aplikan`.`Login`='yuni' AND `aplikan`.`Password`='*FDF3D0567');


// SELECT `level`.`Nama` as namaLVL FROM `level` LEFT JOIN `mhsw` ON `level`.`LevelID`=`mhsw`.`LevelID` LEFT JOIN `dosen` on `level`.`LevelID`=`dosen`.`LevelID` LEFT JOIN `karyawan` ON `level`.`LevelID`=`karyawan`.`LevelID` LEFT JOIN `aplikan` ON `level`.`LevelID`= `aplikan`.`LevelID` WHERE (`mhsw`.`Login` = 'yuni' AND `mhsw`.`Password`='*FDF3D0567') OR (`dosen`.`Login`='yuni' AND `dosen`.`Password`='*FDF3D0567') OR (`karyawan`.`Login`='yuni' AND `karyawan`.`Password`='*FDF3D0567') OR (`aplikan`.`Login`='yuni' AND `aplikan`.`Password`='*FDF3D0567');


// ! dosen, karyawan, aplikasn, mhsw (lvl) (idlogin)
// SELECT `level`.`Nama` as namaLVL, `mhsw`.`Login`, `dosen`.`Login`, `karyawan`.`Login`, `aplikan`.`Login` FROM `level` LEFT JOIN `mhsw` ON `level`.`LevelID`=`mhsw`.`LevelID` LEFT JOIN `dosen` on `level`.`LevelID`=`dosen`.`LevelID` LEFT JOIN `karyawan` ON `level`.`LevelID`=`karyawan`.`LevelID` LEFT JOIN `aplikan` ON `level`.`LevelID`= `aplikan`.`LevelID` WHERE `mhsw`.`Login` = '0002074901' OR `dosen`.`Login`='0002074901' OR `karyawan`.`Login`='0002074901' OR `aplikan`.`Login`='0002074901';


// SELECT 
// `level`.`Nama` as namaLVL
// FROM `level` 
// LEFT JOIN `mhsw` 
// ON `level`.`LevelID`=`mhsw`.`LevelID` 
// LEFT JOIN `dosen`
// on `level`.`LevelID`=`dosen`.`LevelID`
// LEFT JOIN `karyawan`
// ON `level`.`LevelID`=`karyawan`.`LevelID`
// LEFT JOIN `aplikan`
// ON `level`.`LevelID`= `aplikan`.`LevelID`
// WHERE `mhsw`.`Login` = '20110084' 
//  OR `dosen`.`Login`='20110084' 
//  OR `karyawan`.`Login`='20110084'
//  OR `aplikan`.`Login`='20110084';