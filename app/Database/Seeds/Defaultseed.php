<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Defaultseed extends Seeder
{
    public function run()
    {
        $dbprefix = "SM_";
        $authprefix = "sysauth_";


        $data['group'] = [
            [
                'id' => 1,
                'name' => 'Mahasiswa',
                'description' => 'Mahasiswai'
            ],
            [
                'id' => 2,
                'name' => 'Fakultas',
                'description' => 'Fakultas'
            ],
            [
                'id' => 3,
                'name' => 'Prodi',
                'description' => 'Prodi'
            ],
            [
                'id' => 4,
                'name' => 'KaProdi',
                'description' => 'KaProdi'
            ],
            [
                'id' => 5,
                'name' => 'Dekan',
                'description' => 'Dekan'
            ],
            [
                'id' => 6,
                'name' => 'Wakil-Dekan',
                'description' => 'Wakil-Dekan'
            ],
            [
                'id' => 7,
                'name' => 'Dosen',
                'description' => 'Dosen'
            ],
            [
                'id' => 8,
                'name' => 'Pengajar',
                'description' => 'Pengajar'
            ]
        ];
        $data['users'] = [
            [
                'id' => 1,
                'name' => "mahasiswa 1"
            ],
            [
                'id' => 2,
                'name' => "mahasiswa 2"
            ],
            [
                'id' => 3,
                'name' => "mahasiswa 3"
            ],
            [
                'id' => 4,
                'name' => "dosen 1"
            ],
            [
                'id' => 5,
                'name' => "dosen 2"
            ],
            [
                'id' => 6,
                'name' => "dosen 3"
            ],
        ];

        $data['jensiSurat'] = [
            [
                'id' => 1,
                'name' => "test 1",
                'description' => "test diskripsi 1"
            ],
            [
                'id' => 2,
                'name' => "test 2",
                'description' => "test diskripsi 2"
            ],
        ];


        $this->db->table("$authprefix" . 'Group')->insertBatch($data['group']);
        $this->db->table("$authprefix" . 'users')->insertBatch($data['users']);
        $this->db->table("$dbprefix" . 'JenisSurat')->insertBatch($data['jensiSurat']);
    }
}
