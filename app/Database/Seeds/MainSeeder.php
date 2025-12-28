<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MainSeeder extends Seeder
{
    public function run()
    {
        // Execute seeders in order respecting foreign key relationships
        $this->call('CategorySeeder');      // No dependencies
        $this->call('UserSeeder');          // No dependencies
        $this->call('CompanySeeder');       // Depends on UserSeeder
        $this->call('CandidateSeeder');     // Depends on UserSeeder
        $this->call('JobSeeder');           // Depends on UserSeeder, CategorySeeder, CompanySeeder
        $this->call('ApplicationSeeder');   // Depends on JobSeeder, UserSeeder (candidates)
        $this->call('SettingSeeder');       // No dependencies
    }
}
