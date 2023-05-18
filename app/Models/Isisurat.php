<?php

namespace App\Models;

use CodeIgniter\Model;

class Isisurat extends Model
{
    // protected $DBGroup          = 'default';
    protected $table            = 'SM_isiSurat';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    // protected $returnType       = 'array';
    // protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'description',
        'isiSurat',
        'form',
        'JenisSurat_id',
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
        return $this->where('id', $id)->find();
    }

    public function addisiSurat(String $description, String $isiSurat, String $form, int $JenisSurat_id)
    {
        return $this->db->table('SM_isiSurat')->insert([
            'description'   => $description,
            'isiSurat'      => $isiSurat,
            'form'          => $form,
            'JenisSurat_id' => $JenisSurat_id,
        ]);
    }
}
