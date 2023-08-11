<?php

namespace App\Models;

use CodeIgniter\Model;

class JenisSuratMasukModel extends Model
{
    // protected $DBGroup          = 'default';
    protected $table            = 'SM_JenisSuratArchice';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    // protected $returnType       = 'array';
    // protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name',
        'description',
        'TimeStamp',
        'DeleteAt'
    ];

    public function seeall()
    {
        return $this->findAll();
    }
}
