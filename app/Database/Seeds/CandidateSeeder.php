<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\UserModel;
use App\Models\CandidateModel;
use Faker\Factory;

class CandidateSeeder extends Seeder
{
    public function run()
    {
        $userModel = new UserModel();
        $candidateModel = new CandidateModel();
        $faker = Factory::create();

        // Get all candidates
        $candidates = $userModel->where('role', 'candidate')->findAll();

        if (empty($candidates)) {
            return;
        }

        $candidateData = [];
        foreach ($candidates as $candidate) {
            $candidateData[] = [
                'user_id'     => $candidate['id'],
                'full_name'   => $candidate['name'],
                'phone'       => $faker->phoneNumber(),
                'location'    => $faker->city() . ', ' . $faker->country(),
                'resume_path' => 'resumes/sample_cv.pdf',
                'bio'         => $faker->paragraph(2),
                'created_at'  => $candidate['created_at'],
                'updated_at'  => date('Y-m-d H:i:s'),
            ];

            if (count($candidateData) >= 100) {
                $candidateModel->insertBatch($candidateData);
                $candidateData = [];
            }
        }

        if (!empty($candidateData)) {
            $candidateModel->insertBatch($candidateData);
        }
    }
}
