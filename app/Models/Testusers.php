<?php

namespace App\Models;

use CodeIgniter\Model;

class Testusers extends Model
{
    // protected $DBGroup          = 'default';
    protected $table            = 'sysauth_users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    // protected $returnType       = 'array';
    // protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id',
        'name'
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
