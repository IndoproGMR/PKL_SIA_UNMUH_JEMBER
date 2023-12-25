<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterSuratModel extends Model
{
    // protected $DBGroup          = 'default';
    protected $table            = 'SK_MasterSurat';
    protected $primaryKey       = 'id';
    // protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name',
        'description',
        'isiSurat',
        'form',
        'show',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function seeall($showall = false, $onlyshow = 1)
    {
        if ($showall) {
            return $this->findAll();
        }

        return $this->where('show', $onlyshow)->findAll();
    }


    public function seeMasterSuratbyID(String $id, int $showAll = 0)
    {
        $data['error'] = 'y';
        if ($showAll == 1) {
            $datasurat = $this->where('id', $id)->find();
        } else {
            $datasurat = $this->where('id', $id)->where('show', 1)->find();
        }

        if (count($datasurat) > 0) {
            $data['id']          = $datasurat[0]['id'];
            $data['name']        = $datasurat[0]['name'];
            $data['description'] = $datasurat[0]['description'];
            $data['isiSurat']    = base64_decode($datasurat[0]['isiSurat']);
            $data['kop']         = $datasurat[0]['Kopsurat'];
            $data['form']        = base64_decode($datasurat[0]['form']);
            $data['error']       = 'n';
        }
        return $data;
    }


    function seeGrouplvl()
    {
        $db = \Config\Database::connect("siautama", false);
        $builder = $db->table('level')->orderBy('LevelID', 'ASC');
        return $builder->get()->getResultArray();
    }

    function seeNamaPettd()
    {
        $db = \Config\Database::connect("siautama");

        $union = $db
            ->table('karyawan')
            ->select('`karyawan`.`Nama` as namattd, `karyawan`.`Login` as login, `level`.`Nama` as lvl')
            ->join('level', '`level`.`LevelID`=`karyawan`.`LevelID`');

        $builder = $db
            ->table('dosen')
            ->select('`dosen`.`Nama` as namattd,`dosen`.`Login` as login, `level`.`Nama` as lvl')
            ->join('level', '`level`.`LevelID`=`dosen`.`LevelID`')
            ->union($union);

        return $db->newQuery()->fromSubquery($builder, 'q')->orderBy('namattd', 'ASC')->get()->getResultArray();
    }

    public function addMasterSurat(String $jenissurat, String $description, String $isiSurat, String $form, String $kopSurat)
    {
        $data = [
            'id'            => generateIdentifier(),
            'name'          => $jenissurat,
            'description'   => $description,
            'isiSurat'      => base64_encode($isiSurat),
            'Kopsurat'      => $kopSurat,
            'form'          => base64_encode($form),
            'created_at'    => getDateTime()
        ];

        return $this->db->table('SK_MasterSurat')->insert($data);
    }

    function updateMasterSurat($id, String $jenissurat, String $description, String $isiSurat, String $kopSurat)
    {
        return $this->update(
            $id,
            [
                'name'        => $jenissurat,
                'description' => $description,
                'isiSurat'    => base64_encode($isiSurat),
                'Kopsurat'    => $kopSurat,
            ]
        );
    }

    function toggleshow($id)
    {
        $cek = $this->where('id', $id)->find();
        if (!(count($cek) > 0)) {
            return false;
        }

        if ($cek[0]['show'] == 1) {
            return $this->update($id, [
                'show' => 0
            ]);
        }

        if ($cek[0]['show'] == 0) {
            return $this->update($id, [
                'show' => 1
            ]);
        }
    }

    // !delete
    function SeeDel()
    {
        return $this->where('deleted_at !=', null)->withDeleted()->findAll();
    }
}
