<?php

namespace App\Models;

use CodeIgniter\Model;

class JenisSuratMasukModel extends Model
{
    // protected $DBGroup          = 'default';
    protected $table            = 'SM_JenisSuratArchice';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name',
        'description',
        'created_at',
        'updated_at',
        'deleted_at'
    ];


    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';



    // protected $allowCallbacks = true;
    // protected $beforeFind     = ['cekCache'];

    // function cekCache()
    // {
    //     // $cache = \Config\Services::cache();
    //     // $namacache = "Query_" . userInfo()['id'];

    //     // if (cache($namacache) === null) {
    //     //     $cachedata = '';
    //     //     cache()->save($namacache, $cachedata, 10);
    //     // }


    //     d('cekCache');

    //     // if () {

    //     // }
    // }

    public function seeall($showall = 0)
    {
        if ($showall == 1) {
            return $this->select('id,name,description')->findAll();
        }
        return $this->select('id,name,description')->findAll();
    }

    function seebyid($id)
    {
        return $this->select('id,name,description')->find($id);
    }

    function addJenisSurat($data)
    {
        return $this->insert($data);
    }

    function setdeleteJenisSurat($id)
    {
        return $this->delete($id);
        // $data = [
        // 'DeleteAt' => getUnixTimeStamp()
        // ];

        // return $this->update($id, $data);
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
