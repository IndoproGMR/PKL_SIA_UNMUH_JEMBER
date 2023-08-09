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
        $tablee = "JenisSuratAr";
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
                'constraint' => 255
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
        $this->forge->createTable($GLOBALS['dbprefix'] . "$tablee", true, $GLOBALS['attributes']);
    }

    public function down()
    {
        $this->forge->dropTable($GLOBALS['dbprefix'] . 'JenisSuratAr', true);
    }
}
