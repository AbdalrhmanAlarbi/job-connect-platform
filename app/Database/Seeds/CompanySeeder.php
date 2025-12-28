<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\UserModel;
use App\Models\CompanyModel;
use Faker\Factory;

class CompanySeeder extends Seeder
{
    public function run()
    {
        $userModel = new UserModel();
        $companyModel = new CompanyModel();
        $faker = Factory::create();

        // Get all companies
        $companies = $userModel->where('role', 'company')->findAll();

        if (empty($companies)) {
            return;
        }

        // Create companies in batches for better performance
        $companyData = [];
        foreach ($companies as $company) {
            // 70% chance of having website, 30% without
            $hasWebsite = $faker->boolean(70);
            
            $companyData[] = [
                'user_id'     => $company['id'],
                'name'        => $faker->company(),
                'location'    => $faker->city() . ', ' . $faker->country(),
                'logo'        => null, // Logo can be null per migration
                'description' => $faker->paragraph(3), // More realistic description
                'website'     => $hasWebsite ? $faker->url() : null,
                'status'      => $faker->randomElement(['pending', 'approved', 'rejected']),
                'created_at'  => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ];

            // Insert in batches of 50
            if (count($companyData) >= 50) {
                $companyModel->insertBatch($companyData);
                $companyData = [];
            }
        }

        // Insert remaining companies
        if (!empty($companyData)) {
            $companyModel->insertBatch($companyData);
        }
    }
}
