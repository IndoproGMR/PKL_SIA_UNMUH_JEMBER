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

    public function seeall($showall = 0)
    {
        if ($showall == 1) {
            return $this->select('id,name,description')->findAll();
        }
        return $this->select('id,name,description')->where('DeleteAt', null)->findAll();
    }

    function seebyid($id)
    {
        return $this->select('id,name,description')->find($id);
    }

    function addJenisSurat($data)
    {
        return $this->save($data);
    }

    function setdeleteJenisSurat($id)
    {
        $data = [
            'DeleteAt' => getUnixTimeStamp()
        ];

        return $this->update($id, $data);
    }

    function updateJenisSurat($id, $data)
    {
        return $this->update($id, $data);
    }

    function countByid($id)
    {
        return $this->select('count("*") as countSurat')->join('SM_SuratArchice', 'SM_SuratArchice.JenisSuratArchice_id=SM_JenisSuratArchice.id')->where('SM_JenisSuratArchice.id', $id)->find()[0];
    }
}
