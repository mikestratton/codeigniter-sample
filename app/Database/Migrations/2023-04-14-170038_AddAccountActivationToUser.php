<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAccountActivationToUser extends Migration
{
    public function up()
    {
        $this->forge->addColumn('user', [
           'activation_hash' => [
               'type'       => 'VARCHAR',
               'constraint' => 64,
               'unique'     => true
           ],
            'is_active' => [
                'type'    => 'BOOLEAN',
                'null'    => false,
                'default' => false
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropcolumn('user', 'is_active');
        $this->forge->dropcolumn('user', 'activation_hash');
    }
}
