<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DefaultData extends Seeder
{
    public function run()
    {
        $data = [
            'id'          => 0,
            'name'        => 'Default',
            'description' => 'Default',
            'isiSurat'    => 'PHA+RGVmYXVsdDwvcD4=',
            'form'        => 'eyJpbnB1dCI6W119',
            'show'        => 0,
            'created_at'  => '3030-12-30 10:10:10',
            'updated_at'  => null,
            'deleted_at'  => null
        ];
        $this->db->table('SK_MasterSurat')->insert($data);

        $data = [
            'id'            => 1,
            'id_akun'       => '0001096501',
            'password'      => '0404ea373669ec3e2a33581c1a3cd2ea88f1b464aee97922c3535aaff99c6f7b',
            'garam'         => '688787d8ff144c502c7f5cffaafe2cc588d86079f9de88304c26b0cb99ce91c6',
            'register_dari' => '0',
            'TimeStamp'     => 1,
            'DeleteAt'      => Null,
            // 'created_at'    => '3030-12-30 10:10:10',
            // 'updated_at'    => null,
            // 'deleted_at'    => null
        ];
        $this->db->table('AUTH_Account_Admin_Panel')->insert($data);
    }
}
