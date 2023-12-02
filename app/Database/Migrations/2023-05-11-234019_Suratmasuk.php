<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

// $this->dbprefix = 'SM_';
// $this->attributes = ['ENGINE' => 'InnoDB'];


class Suratmasuk extends Migration
{
    protected $dbprefix = 'SM_';
    protected $attributes = ['ENGINE' => 'InnoDB'];

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

            'created_at' => [
                'type'       => 'datetime',
                'default'    => new RawSql('CURRENT_TIMESTAMP')
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
        $this->forge->addKey('created_at');
        $this->forge->createTable($this->dbprefix . "$tablee", true, $this->attributes);


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
                'constraint' => 255
            ],
            'JenisSuratArchice_id' => [
                'type'       => 'int',
                'constraint' => 10,
                'default'    => 0,
                'unsigned'   => true,
            ],

            'created_at' => [
                'type'       => 'datetime',
                'default'    => new RawSql('CURRENT_TIMESTAMP')
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
        $this->forge->addKey('NomerSurat');
        $this->forge->addKey('TanggalSurat');
        $this->forge->addKey('JenisSuratArchice_id');
        $this->forge->addKey('created_at');
        // $this->forge->addForeignKey('JenisSuratArchice_id', $this->dbprefix . 'JenisSuratArchice', 'id', 'CASCADE', 'SET DEFAULT');
        $this->forge->createTable($this->dbprefix . "$tablee", true, $this->attributes);
    }

    public function down()
    {
        $this->forge->dropTable($this->dbprefix . 'JenisSuratArchice', true);
        $this->forge->dropTable($this->dbprefix . 'SuratArchice', true);
    }
}
