<?php

namespace App\Models;

use CodeIgniter\Model;

class AuthUserGroup extends Model
{
    // protected $DBGroup          = 'default';
    protected $table            = 'sysauth_UserGroup';
    // protected $primaryKey       = 'id';
    // protected $useAutoIncrement = true;
    // protected $returnType       = 'array';
    // protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'group_id',
        'user_id'
    ];

    public function cekgroupbyuserid(int $iduser)
    {
        $hasil = $this->select('sysauth_Group.name')->where('user_id', $iduser)->join('sysauth_Group', 'sysauth_Group.id=sysauth_UserGroup.group_id')->find();
        if ($hasil > 0) {
            return $hasil[0];
        }
    }
}
