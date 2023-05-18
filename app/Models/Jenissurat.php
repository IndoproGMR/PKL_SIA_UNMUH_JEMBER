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
        return $this->where('id', $id)->find();
    }
}
