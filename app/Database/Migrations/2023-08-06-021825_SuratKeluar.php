<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

$GLOBALS['dbprefix'] = "SK_";
$GLOBALS['attributes'] = ['ENGINE' => 'InnoDB'];

class SuratKeluar extends Migration
{
    public function up()
    {
        // !JenisSurat
        $tablee = "JenisSurat";
        $fields = [
            'id' => [
                'type'           => 'varchar',
                'constraint'     => 16,
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
            'form' => [
                'type' => 'text'
            ], //json base64
            'show' => [
                'type'       => 'tinyint',
                'constraint' => 1,
                'default'    => 0
            ],    // di show kepada user
            'TimeStamp' => [
                'type'       => 'int',
                'constraint' => 10,
                'unsigned'   => true
            ],
            'DeleteAt' => [
                'type'       => 'int',
                'constraint' => 10,
                'default'    => null
            ],
        ];
        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->addKey('show');
        $this->forge->addKey('TimeStamp');
        $this->forge->createTable($GLOBALS['dbprefix'] . "$tablee", true, $GLOBALS['attributes']);

        // !ttd-SuratMasuk
        $tablee = "ttd_SuratMasuk";
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
            'TimeStamp' => [
                'type'       => 'int',
                'constraint' => 10,
                'unsigned'   => true
            ],
            'JenisSurat_id' => [
                'type'       => 'varchar',
                'constraint' => 16,
                'default'    => 0
            ],
            'mshw_id' => [
                'type'       => 'varchar',
                'constraint' => 20,
                'default'    => 0
            ],
            'DeleteAt' => [
                'type'       => 'int',
                'constraint' => 10,
                'default'    => null
            ]
        ];
        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->addKey('SuratIdentifier');
        $this->forge->addKey('TimeStamp');
        $this->forge->addKey('mshw_id');
        $this->forge->addForeignKey('JenisSurat_id', $GLOBALS['dbprefix'] . 'JenisSurat', 'id', 'CASCADE', 'SET DEFAULT');
        $this->forge->createTable($GLOBALS['dbprefix'] . "$tablee", true, $GLOBALS['attributes']);


        // !ttd
        $tablee = "ttd";
        $fields = [
            'id' => [
                'type'           => 'int',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true
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
            'TimeStamp' => [
                'type'       => 'int',
                'constraint' => 10,
                'unsigned'   => true,
                'default'    => 0
            ],
        ];
        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->addKey('SuratIdentifier');
        $this->forge->addKey('Status');
        $this->forge->addKey('jenisttd');
        $this->forge->addKey('pendattg_id');
        $this->forge->addKey('TimeStamp');

        $this->forge->createTable($GLOBALS['dbprefix'] . "$tablee", true, $GLOBALS['attributes']);
    }

    public function down()
    {
        $this->forge->dropTable($GLOBALS['dbprefix'] . 'JenisSurat', true);
        $this->forge->dropTable($GLOBALS['dbprefix'] . 'ttd_SuratMasuk', true);
        $this->forge->dropTable($GLOBALS['dbprefix'] . 'ttd', true);
    }
}


// ALTER TABLE `SK_ttd`
// ADD INDEX idx_NoSurat(`NoSurat`)