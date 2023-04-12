<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTask extends Migration
{
    public function up()
    {
        $this->forge->addField([
           'id' => [
               'type' => 'INT',
               'constraint' => 5,
               'unsigned' => TRUE,
               'auto_increment' => TRUE
           ],
            'description' => [
                'type' => 'VARCHAR',
                'constraint' => 128
            ]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('task');
    }

    public function down()
    {
        $this->forge->dropTable('task');
    }
}
