<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\CompanyModel;
use App\Models\CategoryModel;
use App\Models\JobModel;
use App\Models\UserModel; // Added UserModel
use Faker\Factory;

class JobSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create();
        $jobModel = new JobModel();
        $userModel = new UserModel();
        $categoryModel = new CategoryModel();
        $companyModel = new CompanyModel();

        // Get all companies and categories
        $companies = $companyModel->findAll();
        $categories = $categoryModel->findAll();

        if (empty($companies) || empty($categories)) {
            return;
        }

        // Valid ENUM values from migrations - must strictly follow these
        $jobTypes = ['Full Time', 'Part Time', 'Freelance', 'Internship'];
        $jobStatuses = ['active', 'closed', 'pending'];
        $jobLevels = ['Entry Level', 'Mid Level', 'Senior Level', 'Director'];
        $experienceLevels = ['0-1 Years', '1-3 Years', '3-5 Years', '5+ Years'];
        $educationLevels = ['High School', 'Bachelor Degree', 'Master Degree', 'PhD'];

        // Map categories to specific job titles for semantic consistency
        $categoryTitles = [
            'Graphics & Design' => ['Senior Graphic Designer', 'UI/UX Designer', 'Art Director', 'Illustrator', 'Motion Graphics Artist', 'Brand Identity Designer'],
            'Code & Programming' => ['Full Stack Developer', 'Backend Engineer', 'Frontend Developer', 'DevOps Engineer', 'Mobile App Developer', 'Software Architect', 'QA Engineer'],
            'Digital Marketing' => ['Social Media Manager', 'SEO Specialist', 'Content Marketing Manager', 'Digital Strategy Lead', 'Email Marketing Specialist'],
            'Video & Animation' => ['Video Editor', '3D Animator', 'VFX Artist', 'Videographer', 'Multimedia Specialist'],
            'Music & Audio' => ['Sound Engineer', 'Music Producer', 'Voice Over Artist', 'Audio Technician'],
            'Account & Finance' => ['Senior Accountant', 'Financial Analyst', 'Auditor', 'Tax Consultant', 'Finance Manager'],
            'Health & Care' => ['Registered Nurse', 'Medical Assistant', 'Physiotherapist', 'General Practitioner', 'Dental Hygienist'],
            'Data & Science' => ['Data Scientist', 'Data Analyst', 'Machine Learning Engineer', 'Lab Technician', 'Research Scientist'],
            'Sales & Business Development' => ['Sales Representative', 'Business Development Manager', 'Account Executive', 'Sales Director'],
            'Education & Training' => ['English Teacher', 'Corporate Trainer', 'Curriculum Developer', 'E-learning Specialist', 'Academic Coordinator'],
            'Engineering & Architecture' => ['Civil Engineer', 'Architect', 'Mechanical Engineer', 'Electrical Engineer', 'Interior Designer'],
            'Legal Services' => ['Corporate Lawyer', 'Paralegal', 'Legal Consultant', 'Compliance Officer'],
            'Customer Support' => ['Customer Support Specialist', 'Call Center Agent', 'Customer Success Manager', 'Technical Support Rep'],
            'Human Resources' => ['HR Manager', 'Recruiter', 'Talent Acquisition Specialist', 'HR Coordinator'],
            'Operations & Logistics' => ['Operations Manager', 'Supply Chain Analyst', 'Logistics Coordinator', 'Warehouse Manager'],
            'Writing & Translation' => ['Copywriter', 'Technical Writer', 'Translator', 'Content Editor', 'Blogger'],
            'AI & Machine Learning' => ['AI Research Scientist', 'NLP Engineer', 'Computer Vision Engineer', 'AI Ethics Officer'],
            'Lifestyle & Health' => ['Personal Trainer', 'Nutritionist', 'Yoga Instructor', 'Life Coach'],
            'Photography & Videography' => ['Professional Photographer', 'Photo Editor', 'Wedding Photographer', 'Drone Operator'],
            'Cybersecurity & IT' => ['Cybersecurity Analyst', 'Network Administrator', 'IT Support Specialist', 'Information Security Manager'],
        ];

        $jobData = [];
        foreach ($companies as $company) {
            // Create exactly 17 jobs per company (30 companies * 17 jobs = 510 jobs)
            $numJobs = 17;
            
            // Assign a primary category to this company to make it "revolve around" it
            $primaryCategory = $categories[array_rand($categories)];

            for ($i = 0; $i < $numJobs; $i++) {
                // 90% chance to use primary category, 10% random (e.g. tech company hiring HR)
                if ($faker->boolean(90)) {
                    $category = $primaryCategory;
                } else {
                    $category = $categories[array_rand($categories)];
                }
                
                // Get a semantically correct title for the chosen category
                $possibleTitles = $categoryTitles[$category['name']] ?? [];
                if (!empty($possibleTitles)) {
                    $title = $faker->randomElement($possibleTitles);
                } else {
                    $title = $faker->jobTitle();
                }
                
                // Status distribution: 70% active, 20% closed, 10% pending
                $statusRand = $faker->numberBetween(1, 100);
                if ($statusRand <= 70) {
                    $status = 'active';
                } elseif ($statusRand <= 90) {
                    $status = 'closed';
                } else {
                    $status = 'pending';
                }

                // Generate salary range - ensure salary_max >= salary_min
                $salaryMin = $faker->numberBetween(3000, 8000); // Monthly salary for Libya context
                $salaryMax = $faker->numberBetween($salaryMin, $salaryMin + 5000);

                $jobData[] = [
                    'company_id'   => $company['id'],
                    'category_id'  => $category['id'],
                    'title'        => $title,
                    'slug'         => url_title($title . '-' . uniqid(), '-', true),
                    'description'  => $faker->paragraphs(4, true),
                    'requirements' => "• " . implode("\n• ", $faker->sentences(5)),
                    'location'     => $faker->city() . ', Libya',
                    'type'         => $faker->randomElement($jobTypes), // Must match ENUM
                    'salary_min'   => $salaryMin,
                    'salary_max'   => $salaryMax,
                    'is_featured'  => $faker->boolean(20) ? 1 : 0, // 20% chance, boolean in DB
                    'status'       => $status, // Must match ENUM: active, closed, pending
                    'level'        => $faker->randomElement($jobLevels),
                    'experience'   => $faker->randomElement($experienceLevels),
                    'education'    => $faker->randomElement($educationLevels),
                    'deadline'     => $faker->dateTimeBetween('+1 month', '+6 months')->format('Y-m-d H:i:s'),
                    'created_at'   => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s'),
                    'updated_at'   => date('Y-m-d H:i:s'),
                ];

                // Insert in batches of 100 for performance
                if (count($jobData) >= 100) {
                    $jobModel->insertBatch($jobData);
                    $jobData = [];
                }
            }
        }

        // Insert remaining jobs
        if (!empty($jobData)) {
            $jobModel->insertBatch($jobData);
        }
    }
}
