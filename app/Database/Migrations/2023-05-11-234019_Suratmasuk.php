<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

$GLOBALS['dbprefix'] = 'SM_';
$GLOBALS['attributes'] = ['ENGINE' => 'InnoDB'];

class Suratmasuk extends Migration
{
    public function up()
    {
        // !JenisSuratAr
        $tablee = "JenisSuratArchice";
        $fields = [
            'id' => [
                'type'           => 'int',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'name' => [
                'type'       => 'varchar',
                'constraint' => 255
            ],
            'description' => [
                'type'       => 'varchar',
                'constraint' => 255,
                'default'    => 'Tanpa Diskripsi'
            ],
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
        $this->forge->addKey('TimeStamp');
        $this->forge->createTable($GLOBALS['dbprefix'] . "$tablee", true, $GLOBALS['attributes']);


        // !SuratMasuk
        $tablee = "SuratArchice";
        $fields = [
            'id' => [
                'type'       => 'varchar',
                'constraint' => 16,
            ],
            'DiskirpsiSurat' => [
                'type'       => 'varchar',
                'constraint' => 255,
                'default'    => 'Tanpa Diskripsi'
            ],
            'NomerSurat' => [
                'type'       => 'varchar',
                'constraint' => 255
            ],
            'TanggalSurat' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'DataSurat' => [
                'type'       => 'TEXT'
            ],
            'NamaFile' => [
                'type'       => 'varchar',
                'constraint' => 16
            ],
            'JenisSuratArchice_id' => [
                'type'       => 'int',
                'constraint' => 10,
                'default'    => 0,
                'unsigned'       => true,
            ],
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
        $this->forge->addKey('NomerSurat');
        $this->forge->addKey('TanggalSurat');
        $this->forge->addKey('JenisSuratArchice_id');
        $this->forge->addKey('TimeStamp');
        $this->forge->addForeignKey('JenisSuratArchice_id', $GLOBALS['dbprefix'] . 'JenisSuratArchice', 'id', 'CASCADE', 'SET DEFAULT');
        $this->forge->createTable($GLOBALS['dbprefix'] . "$tablee", true, $GLOBALS['attributes']);
    }

    public function down()
    {
        $this->forge->dropTable($GLOBALS['dbprefix'] . 'JenisSuratArchice', true);
        $this->forge->dropTable($GLOBALS['dbprefix'] . 'SuratArchice', true);
    }
}
