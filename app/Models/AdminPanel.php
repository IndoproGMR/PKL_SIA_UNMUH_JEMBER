<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminPanel extends Model
{
    // protected $DBGroup          = 'default';
    protected $table            = 'AUTH_Account_Admin_Panel';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    // protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_akun',
        'password',
        'garam',
        'register_dari',
        'TimeStamp',
        'DeleteAt'
    ];

    function cekAdmin($id)
    {
        $data = $this->where('id_akun', $id)->findAll(2);
        if (count($data) == 1) {
            return true;
        }
        return false;
    }

    function adminProsesLogin($user, $pass)
    {
        $garam = $this->select('garam')->where('id_akun', $user)->findAll(2);

        if (count($garam) !== 1) {
            return false;
        }

        $passwordgaram = hash("sha256", $pass . "_" . $garam[0]['garam']);

        $useradmin = $this->where('password', $passwordgaram)->findAll(2);

        if (count($useradmin) !== 1) {
            return false;
        }

        return true;
    }

    function newAdminProses($pass, $regisDari)
    {
        $garam = hash('sha256', generateIdentifier());
        $pass = hash('sha256', $pass . "_" . $garam);
        $data = [
            'id_akun'       => userInfo()['id'],
            'password'      => $pass,
            'garam'         => $garam,
            'register_dari' => $regisDari,
            'TimeStamp'     => getUnixTimeStamp()
        ];

        return $this->insert($data);
    }
}
