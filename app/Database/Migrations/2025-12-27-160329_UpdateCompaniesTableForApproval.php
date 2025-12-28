<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateCompaniesTableForApproval extends Migration
{
    public function up()
    {
        $this->forge->addColumn('companies', [
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'after'      => 'user_id',
                'null'       => true,
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'after'      => 'email',
                'null'       => true,
            ],
        ]);

        $this->forge->modifyColumn('companies', [
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
        ]);

        // Backfill emails for existing companies
        $db = \Config\Database::connect();
        $companies = $db->table('companies')->get()->getResultArray();
        foreach ($companies as $company) {
            if ($company['user_id']) {
                $user = $db->table('users')->where('id', $company['user_id'])->get()->getRowArray();
                if ($user) {
                    $db->table('companies')->where('id', $company['id'])->update(['email' => $user['email']]);
                }
            }
        }
    }

    public function down()
    {
        $this->forge->dropColumn('companies', ['email', 'password']);
        $this->forge->modifyColumn('companies', [
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
        ]);
    }
}
