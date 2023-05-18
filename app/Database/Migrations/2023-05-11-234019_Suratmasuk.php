<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Suratmasuk extends Migration
{
    public function up()
    {

        $dbprefix = "SM_";
        $authprefix = "sysauth_";

        // !group
        $tablee = "Group";
        $fields = [
            'id'          => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'        => ['type' => 'varchar', 'constraint' => 255],
            'description' => ['type' => 'varchar', 'constraint' => 255],
        ];
        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->createTable("$authprefix" . "$tablee", true);


        // !testUser
        $tablee = "users";
        $fields = [
            'id'          => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'        => ['type' => 'varchar', 'constraint' => 255],
        ];
        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->createTable("$authprefix" . "$tablee", true);

        // !group
        $tablee = "UserGroup";
        $fields = [
            'group_id'  => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'user_id'   => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],

        ];
        $this->forge->addField($fields);
        $this->forge->addForeignKey('group_id', 'sysauth_Group', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'sysauth_users', 'id', '', 'CASCADE'); // dari unmuh
        $this->forge->createTable("$authprefix" . "$tablee", true);

        // !JenisSurat
        $tablee = "JenisSurat";
        $fields = [
            'id'          => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'        => ['type' => 'varchar', 'constraint' => 255],
            'description' => ['type' => 'varchar', 'constraint' => 255],
        ];
        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->createTable("$dbprefix" . "$tablee", true);


        // !isiSurat
        $tablee = "isiSurat";
        $fields = [
            'id'            => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'description'   => ['type' => 'varchar', 'constraint' => 255],
            'isiSurat'      => ['type' => 'text'],
            'form'          => ['type' => 'text'],                          //json
            'JenisSurat_id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
        ];
        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('JenisSurat_id', "$dbprefix" . 'JenisSurat', 'id', '', 'CASCADE');
        $this->forge->createTable("$dbprefix" . "$tablee", true);


        // !ttd-SuratPenandatangan
        $tablee = "ttd_SuratPenandatangan";
        $fields = [
            'JenisSurat_id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'user_id'       => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
        ];
        $this->forge->addField($fields);
        $this->forge->addForeignKey('JenisSurat_id', "$dbprefix" . 'JenisSurat', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('user_id', "$authprefix" . 'users', 'id', '', 'CASCADE'); // dari unmuh
        $this->forge->createTable("$dbprefix" . "$tablee", true);

        // !ttd-SuratMasuk
        $tablee = "ttd_SuratMasuk";
        $fields = [
            'id'            => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'NoSurat'       => ['type' => 'varchar', 'constraint' => 64],
            'DataTambahan'  => ['type' => 'text'],                         //json
            'TimeStamp'     => ['type' => 'int', 'constraint' => 12],
            'JenisSurat_id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'user_id'       => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],

        ];
        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('JenisSurat_id', "$dbprefix" . 'JenisSurat', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('user_id', "$authprefix" . 'users', 'id', '', 'CASCADE'); // dari unmuh
        $this->forge->createTable("$dbprefix" . "$tablee", true);

        // !ttd
        $tablee = "ttd";
        $fields = [
            'id'            => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'Status'        => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 0],
            'hash'          => ['type' => 'text'],                       //json
            'RandomStr'     => ['type' => 'varchar', 'constraint' => 8],
            'TimeStamp'     => ['type' => 'int', 'constraint' => 12],
            'SuratMasuk_id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'user_id'       => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],

        ];
        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('SuratMasuk_id', "$dbprefix" . 'ttd_SuratMasuk', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('user_id', "$authprefix" . 'users', 'id', '', 'CASCADE'); // dari unmuh
        $this->forge->createTable("$dbprefix" . "$tablee", true);
    }

    public function down()
    {
        $dbprefix = "SM_";

        $this->forge->dropTable($dbprefix . 'JenisSurat', true);
        $this->forge->dropTable($dbprefix . 'isiSurat', true);
        $this->forge->dropTable($dbprefix . 'ttd_SuratPenandatangan', true);
        $this->forge->dropTable($dbprefix . 'ttd_SuratMasuk', true);
        $this->forge->dropTable($dbprefix . 'ttd', true);


        $authprefix = "sysauth_";

        $this->forge->dropTable($authprefix . 'Group', true);
        $this->forge->dropTable($authprefix . 'UserGroup', true);
        $this->forge->dropTable($authprefix . 'users', true);
    }
}
