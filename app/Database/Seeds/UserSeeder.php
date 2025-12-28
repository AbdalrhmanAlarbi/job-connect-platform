<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\Test\Fabricator;
use App\Models\UserModel;

class UserSeeder extends Seeder
{
    public function run()
    {
        $model = new UserModel();
        $faker = \Faker\Factory::create();

        // 1. Create 2 Admins
        $model->insert([
            'name'     => 'Admin User',
            'email'    => 'admin@libyanjobs.com',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'role'     => 'admin',
        ]);
        $model->insert([
            'name'     => 'Super Admin',
            'email'    => 'superadmin@libyanjobs.com',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'role'     => 'admin',
        ]);

        // 2. Create 30 Employers (one for each company)
        $employerData = [];
        for ($i = 0; $i < 30; $i++) {
            $employerData[] = [
                'name'     => $faker->name(),
                'email'    => $faker->unique()->safeEmail(),
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'role'     => 'company',
                'created_at' => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }
        $model->insertBatch($employerData, 30); 

        // 3. Create 1000 Candidates ("Big Number")
        $candidateData = [];
        for ($i = 0; $i < 1000; $i++) {
            $candidateData[] = [
                'name'     => $faker->name(),
                'email'    => $faker->unique()->safeEmail(),
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'role'     => 'candidate',
                'created_at' => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }
        $model->insertBatch($candidateData, 100); // Insert in batches of 100
    }
}
