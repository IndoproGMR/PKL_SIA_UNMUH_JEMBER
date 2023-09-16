<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

$GLOBALS['dbprefix'] = "AUTH_";
$GLOBALS['attributes'] = ['ENGINE' => 'InnoDB'];

class AuthAPI extends Migration
{
    public function up()
    {
        // !Account_Admin_Panel
        $tablee = "Account_Admin_Panel";
        $fields = [
            'id' => [
                'type'           => 'int',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true
            ],

            'id_akun' => [
                'type'       => 'varchar',
                'constraint' => 20
            ],

            'password' => [
                'type'       => 'varchar',
                'constraint' => 64
            ],

            'garam' => [
                'type'       => 'varchar',
                'constraint' => 64
            ],

            'register_dari' => [
                'type' => 'text'
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
        $this->forge->addKey('id_akun');
        $this->forge->addKey('password');
        $this->forge->addKey('TimeStamp');
        $this->forge->createTable($GLOBALS['dbprefix'] . "$tablee", true, $GLOBALS['attributes']);


        // !Account_Admin_Panel
        $tablee = "temp_pin";
        $fields = [
            'id' => [
                'type'           => 'int',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true
            ],

            'id_akun_pembuat' => [
                'type'       => 'varchar',
                'constraint' => 20
            ],

            'pin1' => [
                'type'       => 'varchar',
                'constraint' => 64
            ],

            'pin2' => [
                'type'       => 'varchar',
                'constraint' => 10,
                'default'    => NULL
            ],

            'register_oleh' => [
                'type'       => 'varchar',
                'constraint' => 20,
                'default'    => NULL
            ],

            'TimeStamp' => [
                'type'       => 'int',
                'constraint' => 10,
                'unsigned'   => true
            ],

            'expired' => [
                'type'       => 'int',
                'constraint' => 10,
                'default'    => null
            ],
        ];
        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->addKey('id_akun_pembuat');
        $this->forge->addKey('pin1');
        $this->forge->addKey('pin2');
        $this->forge->addKey('register_oleh');
        $this->forge->addKey('TimeStamp');
        $this->forge->addKey('expired');
        $this->forge->createTable($GLOBALS['dbprefix'] . "$tablee", true, $GLOBALS['attributes']);
    }

    public function down()
    {
        $this->forge->dropTable($GLOBALS['dbprefix'] . 'Account_Admin_Panel', true);
        $this->forge->dropTable($GLOBALS['dbprefix'] . 'temp_pin', true);
    }
}
