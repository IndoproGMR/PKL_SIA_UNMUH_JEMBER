<?php

namespace App\Models;

use CodeIgniter\Model;

class ServerConfig extends Model
{
    // protected $DBGroup          = 'default';
    protected $table            = 'Server_Config';
    protected $primaryKey       = 'id';
    // protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name',
        'value',
        'UpdateTime',
        'DeleteAt'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'UpdateTime';
    protected $updatedField  = 'UpdateTime';
    protected $deletedField  = 'DeleteAt';

    function addServerConfig($name, $value)
    {
        $id = $this->where('name', $name)->where('DeleteAt', null)->find();

        $data = [
            'name' => $name,
            'value' => base64_encode($value)
        ];

        if (count($id) !== 1) {
            return $this->save($data);
        }

        return $this->update($id[0]['id'], $data);
    }

    function getServerConfig($name)
    {
        $data = $this->where('name', $name)->find();
        if (count($data) !== 1) {
            return "";
        }
        return base64_decode($data[0]['value']);
    }

    function deleteServerConfig($name)
    {
        $id = $this->where('name', $name)->find()[0]['id'];
        return $this->delete($id);
    }
}
