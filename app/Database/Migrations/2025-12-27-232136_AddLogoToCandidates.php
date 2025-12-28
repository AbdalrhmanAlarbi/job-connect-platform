<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddLogoToCandidates extends Migration
{
    public function up()
    {
        $fields = [
            'logo' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'after'      => 'bio'
            ],
        ];
        $this->forge->addColumn('candidates', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('candidates', 'logo');
    }
}
