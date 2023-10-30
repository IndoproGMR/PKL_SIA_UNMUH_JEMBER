<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

$GLOBALS['dbprefix'] = "Server_";
$GLOBALS['attributes'] = ['ENGINE' => 'InnoDB'];

class ServerConfig extends Migration
{
    public function up()
    {
        // !JenisSurat
        $tablee = "Config";
        $fields = [
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'       => 'varchar',
                'constraint' => 255
            ],
            'value' => [
                'type' => 'text'
            ],
            'UpdateTime' => [
                'type'       => 'DATETIME',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'DeleteAt' => [
                'type'       => 'DATETIME',
                'default'    => null
            ],
        ];
        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->addKey('name');
        $this->forge->addKey('UpdateTime');
        $this->forge->createTable($GLOBALS['dbprefix'] . "$tablee", true, $GLOBALS['attributes']);
    }

    public function down()
    {
        $this->forge->dropTable($GLOBALS['dbprefix'] . 'Config', true);
    }
}
