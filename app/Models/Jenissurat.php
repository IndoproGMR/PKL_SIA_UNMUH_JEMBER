<?php

namespace App\Models;

use CodeIgniter\Model;

class Jenissurat extends Model
{
    // protected $DBGroup          = 'default';
    protected $table            = 'SM_JenisSurat';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    // protected $returnType       = 'array';
    // protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name',
        'isiSurat',
        'form',
        'description'
    ];


    public function countdb()
    {
        return $this->countAllResults();
    }

    public function seeall()
    {
        return $this->findAll();
    }

    public function seebyID(int $id)
    {
        $data = $this->where('id', $id)->find()[0];

        // helper('text');
        // $data['isiSurat'] = strip_slashes(base64_decode($data['isiSurat']));
        // $data['form'] = strip_slashes(base64_decode($data['form']));
        $data['isiSurat'] = base64_decode($data['isiSurat']);
        $data['form'] = base64_decode($data['form']);
        return $data;
    }

    public function addJenisSurat(String $jenissurat, String $description, String $isiSurat, String $form)
    {
        return $this->db->table('SM_JenisSurat')->insert([
            'name'          => $jenissurat,
            'description'   => $description,
            'isiSurat'      => base64_encode($isiSurat),
            'form'          => base64_encode($form),
        ]);
    }

    function updateJenisSurat(int $id, String $jenissurat, String $description, String $isiSurat, String $form)
    {
        return $this->update($id, [
            'name'          => $jenissurat,
            'description'   => $description,
            'isiSurat'      => base64_encode($isiSurat),
            'form'          => base64_encode($form),
        ]);
    }

    function seegrouplvl()
    {
        $db = \Config\Database::connect("siautama", false);
        $sql = "SELECT `Nama` FROM `level` ORDER BY `LevelID` ASC;";
        return $db->query($sql)->getResultArray();
    }

    function seeNamaPettd()
    {
        $db = \Config\Database::connect("siautama", false);
        $sql = "SELECT `dosen`.`Nama` as namattd, `dosen`.`Login` as login, `level`.`Nama` as lvl FROM dosen LEFT JOIN `level` ON `level`.`LevelID`=`dosen`.`LevelID` UNION SELECT `karyawan`.`Nama` as namattd, `karyawan`.`Login` as login, `level`.`Nama` as lvl FROM karyawan LEFT JOIN `level` ON `level`.`LevelID`=`karyawan`.`LevelID` ORDER by namattd;";
        // $sql = "SELECT `dosen`.`Nama` as namattd, `dosen`.`Login` as login, `level`.`Nama` as lvl FROM dosen LEFT JOIN `level` ON `level`.`LevelID`=`dosen`.`LevelID` UNION SELECT `karyawan`.`Nama` as namattd, `karyawan`.`Login` as login, `level`.`Nama` as lvl FROM karyawan LEFT JOIN `level` ON `level`.`LevelID`=`karyawan`.`LevelID` WHERE `level`.`Nama` = 'Dosen' or `level`.`Nama` = 'Pengajaran Fakultas' ORDER by namattd;";
        return $db->query($sql)->getResultArray();
    }
}

// INSERT INTO `SM_JenisSurat` (`id`, `name`, `description`, `isiSurat`, `form`) VALUES (19, 'test', 'test multi data', 'bmFtYTp7e25hbWF9fQ==', 'eyJpbnB1dCI6WyJuYW1hIl0sIlRURCI6WyJHcm91cF9Eb3NlbiIsIkdyb3VwX01haGFzaXN3YSIsIkdyb3VwX0NhbG9uIE1haGFzaXN3YSIsIlBlcm9yYW5nYW5fMDAxNDAyNzUwMSJdfQ==');



// SELECT
// `dosen`.`Nama` as namattd,
// `dosen`.`Login` as login,
// `level`.`Nama` as lvl
// FROM dosen
// LEFT JOIN `level` ON `level`.`LevelID`=`dosen`.`LevelID`
// UNION
// SELECT
// `karyawan`.`Nama` as namattd,
// `karyawan`.`Login` as login,
// `level`.`Nama` as lvl
// FROM karyawan
// LEFT JOIN `level` ON `level`.`LevelID`=`karyawan`.`LevelID`
// WHERE `level`.`Nama` = 'Dosen' 
// or `level`.`Nama` = 'Pengajaran Fakultas'
// or `level`.`Nama` = 'Kepala Akademik'
// or `level`.`Nama` = 'Fakultas'
// or `level`.`Nama` = 'Kaprodi / Kajur'
// or `level`.`Nama` = 'Rektorat'
// or `level`.`Nama` = 'Pengajaran Fakultas'
// or `level`.`Nama` = 'Presenter'
// or `level`.`Nama` = 'Staf PMB'
// ORDER by namattd