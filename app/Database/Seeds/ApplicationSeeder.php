<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\ApplicationModel;
use App\Models\JobModel;
use App\Models\UserModel;
use Faker\Factory;

class ApplicationSeeder extends Seeder
{
    public function run()
    {
        $applicationModel = new ApplicationModel();
        $jobModel = new JobModel();
        $candidateModel = new \App\Models\CandidateModel();
        $faker = Factory::create();

        // Get all jobs (only active jobs typically get applications)
        $jobs = $jobModel->where('status', 'active')->findAll();
        // Get all candidates
        $candidates = $candidateModel->findAll();

        if (empty($jobs) || empty($candidates)) {
            return;
        }

        // Valid ENUM values from migration - must strictly follow: pending, reviewed, accepted, rejected
        $statuses = ['pending', 'reviewed', 'accepted', 'rejected'];
        // Status distribution weights: pending (60%), reviewed (20%), accepted (10%), rejected (10%)
        $statusWeights = [
            'pending' => 60,
            'reviewed' => 20,
            'accepted' => 10,
            'rejected' => 10,
        ];

        $applicationData = [];
        
        foreach ($jobs as $job) {
            // 5-15 applications per job for a more balanced dataset
            $numApplications = rand(5, 15);
            
            // Shuffle candidates to avoid same candidates always applying
            shuffle($candidates);
            $selectedCandidates = array_slice($candidates, 0, min($numApplications, count($candidates)));
            
            foreach ($selectedCandidates as $candidate) {
                // Select status based on weights
                $rand = $faker->numberBetween(1, 100);
                $status = 'pending';
                if ($rand <= $statusWeights['pending']) {
                    $status = 'pending';
                } elseif ($rand <= $statusWeights['pending'] + $statusWeights['reviewed']) {
                    $status = 'reviewed';
                } elseif ($rand <= $statusWeights['pending'] + $statusWeights['reviewed'] + $statusWeights['accepted']) {
                    $status = 'accepted';
                } else {
                    $status = 'rejected';
                }

                $applicationData[] = [
                    'job_id'       => $job['id'],
                    'candidate_id' => $candidate['id'],
                    'cover_letter' => $faker->paragraphs(3, true),
                    'resume_path'  => $candidate['resume_path'],
                    'status'       => $status,
                    'created_at'   => $faker->dateTimeBetween($job['created_at'] ?? '-1 year', 'now')->format('Y-m-d H:i:s'),
                    'updated_at'   => date('Y-m-d H:i:s'),
                ];

                // Insert in batches of 100 for performance
                if (count($applicationData) >= 100) {
                    $applicationModel->insertBatch($applicationData);
                    $applicationData = [];
                }
            }
        }

        // Insert remaining applications
        if (!empty($applicationData)) {
            $applicationModel->insertBatch($applicationData);
        }
    }
}

