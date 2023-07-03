<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Suratmasuk extends Migration
{
    public function up()
    {
        $dbprefix = "SM_";


        // !JenisSurat
        $tablee = "JenisSurat";
        $fields = [
            'id'          => ['type' => 'int', 'constraint'     => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'        => ['type' => 'varchar', 'constraint' => 255],
            'description' => ['type' => 'varchar', 'constraint' => 255],
            'isiSurat'    => ['type' => 'text'],                          //json base64
            'form'        => ['type' => 'text'],                          //json base64
            'show'        => ['type' => 'tinyint', 'constraint' => 1,  'default'  => 0], // di show kepada user
            'delete'      => ['type' => 'int', 'constraint'     => 12, 'default'  => null]
        ];
        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->createTable("$dbprefix" . "$tablee", true);


        // !ttd-SuratMasuk
        $tablee = "ttd_SuratMasuk";
        $fields = [
            'id'            => ['type' => 'int', 'constraint'     => 11, 'unsigned' => true, 'auto_increment' => true],
            'NoSurat'       => ['type' => 'varchar', 'constraint' => 64],
            'DataTambahan'  => ['type' => 'text'],                         //json base64
            'TimeStamp'     => ['type' => 'int', 'constraint' => 12],
            'JenisSurat_id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'mshw_id'       => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],

        ];
        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('JenisSurat_id', "$dbprefix" . 'JenisSurat', 'id', '', 'CASCADE');
        $this->forge->createTable("$dbprefix" . "$tablee", true);


        // !ttd
        $tablee = "ttd";
        $fields = [
            'id'            => ['type' => 'int', 'constraint'     => 11, 'unsigned' => true, 'auto_increment' => true],
            'NoSurat'       => ['type' => 'varchar', 'constraint' => 8,  'default'  => 0],
            'Status'        => ['type' => 'tinyint', 'constraint' => 1,  'default'  => 0],
            'hash'          => ['type' => 'text', 'default'       => NULL],
            'jenisttd'      => ['type' => 'varchar', 'constraint' => 12],              // group apa perorangan
            'pendattg_id'   => ['type' => 'varchar', 'constraint' => 20, 'default'  => NULL], // nama grup atau id login
            'TimeStamp'     => ['type' => 'int', 'constraint'     => 12, 'default'  => 0],
        ];
        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->createTable("$dbprefix" . "$tablee", true);
    }

    public function down()
    {
        $dbprefix = "SM_";

        $this->forge->dropTable($dbprefix . 'JenisSurat', true);
        $this->forge->dropTable($dbprefix . 'ttd_SuratMasuk', true);
        $this->forge->dropTable($dbprefix . 'ttd', true);
    }
}


// ALTER TABLE `SM_ttd`
// ADD INDEX idx_NoSurat(`NoSurat`)