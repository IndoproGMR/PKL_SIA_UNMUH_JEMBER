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
            'id'          => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'        => ['type' => 'varchar', 'constraint' => 255],
            'description' => ['type' => 'varchar', 'constraint' => 255],
            'isiSurat'    => ['type' => 'text'],
            'form'        => ['type' => 'text'],                          //json
        ];
        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->createTable("$dbprefix" . "$tablee", true);


        // !ttd-SuratMasuk
        $tablee = "ttd_SuratMasuk";
        $fields = [
            'id'            => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'NoSurat'       => ['type' => 'varchar', 'constraint' => 64],
            'DataTambahan'  => ['type' => 'text'],                         //json
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
            'id'            => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'Status'        => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 0],
            'hash'          => ['type' => 'text'],
            'RandomStr'     => ['type' => 'varchar', 'constraint' => 8],
            'TimeStamp'     => ['type' => 'int', 'constraint' => 12],
            'SuratMasuk_id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'jenisttd'      => ['type' => 'varchar', 'constraint' => 12],              // group apa perorangan
            'pendattg_id'   => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
        ];
        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('SuratMasuk_id', "$dbprefix" . 'ttd_SuratMasuk', 'id', '', 'CASCADE');
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
    }
}
