<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MakeCompanyLocationNullable extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('companies', [
            'location' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->modifyColumn('companies', [
            'location' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => false,
            ],
        ]);
    }
}
