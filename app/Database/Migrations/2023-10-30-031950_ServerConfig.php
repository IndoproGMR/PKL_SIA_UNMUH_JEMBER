<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

$this->dbprefix = "Server_";
// $this->attributes = ['ENGINE' => 'InnoDB'];

class ServerConfig extends Migration
{
    protected $dbprefix = 'Server_';
    protected $attributes = ['ENGINE' => 'InnoDB'];

    public function up()
    {
        // !Config
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
                'default'    => new RawSql('CURRENT_TIMESTAMP'),
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
        $this->forge->createTable($this->dbprefix . "$tablee", true, $this->attributes);


        // !BlackList
        $tablee = "MHSW_BlackList";
        $fields = [
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'mshw_id' => [
                'type'       => 'varchar',
                'constraint' => 20
            ],
            'description' => [
                'type'       => 'varchar',
                'constraint' => 255
            ],
            'Status' => [
                'type'       => 'tinyint',
                'constraint' => 1,
                'default'    => 0
            ], // 0 = UnBan; 1 = Ban; 2 =

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
        $this->forge->addKey('mshw_id');
        $this->forge->addKey('Status');
        $this->forge->addKey('UpdateTime');
        $this->forge->createTable($this->dbprefix . "$tablee", true, $this->attributes);
    }

    public function down()
    {
        $this->forge->dropTable($this->dbprefix . 'Config', true);
        $this->forge->dropTable($this->dbprefix . 'MHSW_BlackList', true);
    }
}
