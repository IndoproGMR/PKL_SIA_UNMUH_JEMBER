<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

// $this->dbprefix = "SK_";
// $this->attributes = ['ENGINE' => 'InnoDB'];

class SuratKeluar extends Migration
{
    protected $dbprefix = 'SK_';
    protected $attributes = ['ENGINE' => 'InnoDB'];

    public function up()
    {
        // !MasterSurat
        $tablee = "MasterSurat";
        $fields = [
            'id' => [
                'type'       => 'varchar',
                'constraint' => 16,
            ],
            'name' => [
                'type'       => 'varchar',
                'constraint' => 255
            ],
            'description' => [
                'type'       => 'varchar',
                'constraint' => 255
            ],
            'isiSurat' => [
                'type' => 'text'
            ], //json base64

            'Kopsurat' => [
                'type'       => 'varchar',
                'constraint' => 510,
                'default'    => 'defaultKop'
            ], //json base64

            'form' => [
                'type' => 'text'
            ], //json base64
            'show' => [
                'type'       => 'tinyint',
                'constraint' => 1,
                'default'    => 0
            ],    // di show kepada user

            'created_at' => [
                'type'       => 'datetime',
                'default' => new RawSql('CURRENT_TIMESTAMP')
            ],
            'updated_at' => [
                'type'       => 'datetime',
                'default'    => null
            ],
            'deleted_at' => [
                'type'       => 'datetime',
                'default'    => null
            ],
        ];
        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->addKey('show');
        $this->forge->addKey('created_at');
        $this->forge->createTable($this->dbprefix . "$tablee", true, $this->attributes);

        // !ttd-SuratMasuk
        $tablee = "ttd_MintaSurat";
        $fields = [
            'id' => [
                'type'           => 'int',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'NoSurat' => [
                'type'       => 'varchar',
                'constraint' => 128,
                'default'    => 'Belum_Memiliki_No_Surat'
            ],
            'SuratIdentifier' => [
                'type'       => 'varchar',
                'constraint' => 16
            ],
            'DataTambahan' => [
                'type' => 'text'
            ],                         //json base64
            'MasterSurat_id' => [
                'type'       => 'varchar',
                'constraint' => 16,
                'default'    => 0
            ],
            'mshw_id' => [
                'type'       => 'varchar',
                'constraint' => 20,
                'default'    => 0
            ],
            'Status' => [
                'type'       => 'tinyint',
                'constraint' => 1,
                'default'    => 0
            ], // 0 = aman; 1 = Reported; 2 = 
            'Report_diskripsi' => [
                'type'       => 'varchar',
                'constraint' => 255,
                'default'    => Null
            ],

            'created_at' => [
                'type'       => 'datetime',
                'default' => new RawSql('CURRENT_TIMESTAMP')
            ],
            'updated_at' => [
                'type'       => 'datetime',
                'default'    => null
            ],
            'deleted_at' => [
                'type'       => 'datetime',
                'default'    => null
            ]
        ];
        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->addKey('SuratIdentifier');
        $this->forge->addKey('created_at');
        $this->forge->addKey('mshw_id');
        $this->forge->addForeignKey('MasterSurat_id', $this->dbprefix . 'MasterSurat', 'id', 'CASCADE', 'SET DEFAULT');
        $this->forge->createTable($this->dbprefix . "$tablee", true, $this->attributes);


        // !ttd
        $tablee = "ttd";
        $fields = [
            'id' => [
                'type'       => 'varchar',
                'constraint' => 16
            ],
            'SuratIdentifier' => [
                'type'       => 'varchar',
                'constraint' => 16
            ],
            'Status' => [
                'type'       => 'tinyint',
                'constraint' => 1,
                'default'    => 0
            ],
            'hash' => [
                'type'    => 'text',
                'default' => NULL
            ],
            'qrcodeName' => [
                'type'       => 'varchar',
                'constraint' => 30,
                'default'    => NULL
            ],  // QRcode name untuk di panggil
            'jenisttd' => [
                'type'       => 'varchar',
                'constraint' => 12
            ],                     // group apa perorangan
            'pendattg_id' => [
                'type'       => 'varchar',
                'constraint' => 20,
                'default'    => NULL
            ], // nama grup atau id login

            'created_at' => [
                'type'       => 'datetime',
                'default' => new RawSql('CURRENT_TIMESTAMP')
            ],
            'updated_at' => [
                'type'       => 'datetime',
                'default'    => null
            ],
            'deleted_at' => [
                'type'       => 'datetime',
                'default'    => null
            ]
        ];
        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->addKey('SuratIdentifier');
        $this->forge->addKey('Status');
        $this->forge->addKey('jenisttd');
        $this->forge->addKey('pendattg_id');
        $this->forge->addKey('created_at');
        $this->forge->addKey('updated_at');

        $this->forge->createTable($this->dbprefix . "$tablee", true, $this->attributes);
    }

    public function down()
    {
        $this->forge->dropTable($this->dbprefix . 'MasterSurat', true);
        $this->forge->dropTable($this->dbprefix . 'ttd_MintaSurat', true);
        $this->forge->dropTable($this->dbprefix . 'ttd', true);
    }
}
