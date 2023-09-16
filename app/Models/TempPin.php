<?php

namespace App\Models;

use CodeIgniter\Model;

class TempPin extends Model
{
    // protected $DBGroup          = 'default';
    protected $table            = 'AUTH_temp_pin';
    protected $primaryKey       = 'id';
    // protected $useAutoIncrement = true;
    // protected $returnType       = 'array';
    // protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_akun_pembuat',
        'pin1',
        'pin2',
        'register_oleh',
        'TimeStamp',
        'expired'
    ];

    function buatPin($pin1)
    {
        $TimeStamp = getUnixTimeStamp();
        $exp = $TimeStamp + 300;

        $this->where('expired < ', $TimeStamp)->delete();

        $data = [
            'id_akun_pembuat' => userInfo()['id'],
            'pin1'            => $pin1,
            'TimeStamp'       => $TimeStamp,
            'expired'         => $exp
        ];
        return $this->insert($data, true);
    }

    function confirmPin($pin1)
    {
        $TimeStamp = getUnixTimeStamp();
        $cek = $this->where('expired >', $TimeStamp)->where('pin1', $pin1)->where('pin2', '')->findAll(2);

        if (count($cek) !== 1) {
            return false;
        }

        $data = [
            'pin2'          => hash256(generateIdentifier(), 10),
            'register_oleh' => userInfo()['id']
        ];
        return $this->update($cek[0]['id'], $data);
    }

    function confirmPin2($pin1, $pin2)
    {
        $TimeStamp = getUnixTimeStamp();
        $cek = $this->where('expired >', $TimeStamp)->where('pin1', $pin1)->where('pin2', $pin2)->findAll(2);
        if (count($cek) !== 1) {
            return false;
        }
        return true;
    }

    function refreshPin($pin1)
    {
        return $this->where('pin1', $pin1)->findAll(2)[0];
    }
}
