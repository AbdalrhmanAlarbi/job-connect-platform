<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'key'        => 'site_name',
                'value'      => 'LibyanJobs',
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'key'        => 'admin_email',
                'value'      => 'admin@libyanjobs.com',
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'key'        => 'maintenance_mode',
                'value'      => '0',
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('settings')->insertBatch($data);
    }
}
