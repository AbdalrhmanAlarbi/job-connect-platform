<?php

namespace App\Controllers;

use App\Models\JobModel;
use App\Models\ApplicationModel;
use App\Models\CompanyModel;
use App\Models\CategoryModel;
use App\Models\ActivityLogModel;

class Company extends BaseController
{
    protected $company;

    public function __construct()
    {
        // Simple check for company role
        if (session()->get('user_role') !== 'company') {
            header('Location: ' . base_url('auth/login'));
            exit;
        }

        $companyModel = new CompanyModel();
        $this->company = $companyModel->where('user_id', session()->get('user_id'))->first();

        if (!$this->company) {
            header('Location: ' . base_url('auth/login'));
            exit;
        }
    }

    public function index()
    {
        $jobModel = new JobModel();
        $applicationModel = new ApplicationModel();

        $totalJobs = $jobModel->where('company_id', $this->company['id'])->countAllResults();
        
        // Count total PENDING applications for all jobs of this company
        $totalApplications = $applicationModel->select('COUNT(applications.id) as count')
            ->join('jobs', 'jobs.id = applications.job_id')
            ->where('jobs.company_id', $this->company['id'])
            ->where('applications.status', 'pending')
            ->first()['count'] ?? 0;

        // Fetch Jobs with their specific application count
        $jobs = $jobModel->select('jobs.*, COUNT(applications.id) as application_count')
            ->join('applications', 'applications.job_id = jobs.id AND applications.status = "pending"', 'left')
            ->where('jobs.company_id', $this->company['id'])
            ->groupBy('jobs.id')
            ->orderBy('jobs.created_at', 'DESC')
            ->findAll();

        $data = [
            'title'              => 'Company Dashboard - LibyanJobs',
            'company'            => $this->company,
            'total_jobs'         => $totalJobs,
            'total_applications' => $totalApplications,
            'jobs'               => $jobs
        ];

        echo view('templates/header', $data);
        echo view('company_home', $data);
        echo view('templates/footer');
    }

    public function postJob()
    {
        $categoryModel = new CategoryModel();
        $data = [
            'title'      => 'Post a New Job - LibyanJobs',
            'categories' => $categoryModel->findAll()
        ];
        echo view('templates/header', $data);
        echo view('company/post_job', $data);
        echo view('templates/footer');
    }

    public function saveJob()
    {
        $jobModel = new JobModel();
        
        // Explicit Validation for All Fields
        
        // 1. Job Title: Letters and standard punctuation only
        $title = $this->request->getPost('title');
        if (empty($title)) {
            return redirect()->back()->withInput()->with('error', 'Please enter a Job Title.');
        }
        if (!preg_match('/^[a-zA-Z\s\.\-\(\)]+$/', $title)) {
             return redirect()->back()->withInput()->with('error', 'Job Title contains invalid characters. Only letters are allowed.');
        }

        if (empty($this->request->getPost('type'))) {
            return redirect()->back()->withInput()->with('error', 'Please select a Job Type.');
        }
        if (empty($this->request->getPost('category_id'))) {
            return redirect()->back()->withInput()->with('error', 'Please select a Job Category.');
        }
        if (empty($this->request->getPost('level'))) {
            return redirect()->back()->withInput()->with('error', 'Please select the Experience Level.');
        }
        
        // 2. Salary: Numbers only (integers)
        $salaryMin = $this->request->getPost('salary_min');
        if (empty($salaryMin) || !ctype_digit($salaryMin) || $salaryMin < 0) {
            return redirect()->back()->withInput()->with('error', 'Minimum Salary must be a valid number (no letters or decimals).');
        }

        $salaryMax = $this->request->getPost('salary_max');
        if (empty($salaryMax) || !ctype_digit($salaryMax) || $salaryMax < 0) {
            return redirect()->back()->withInput()->with('error', 'Maximum Salary must be a valid number (no letters or decimals).');
        }
        if ($salaryMax < $salaryMin) {
            return redirect()->back()->withInput()->with('error', 'Maximum Salary cannot be less than Minimum Salary.');
        }

        if (empty($this->request->getPost('experience'))) {
            return redirect()->back()->withInput()->with('error', 'Please specify the required Experience (e.g. 2-3 Years).');
        }
        if (empty($this->request->getPost('education'))) {
            return redirect()->back()->withInput()->with('error', 'Please specify the required Education level.');
        }
        
         // 3. Location: Letters, spaces, standard address punctuation
        $location = $this->request->getPost('location');
        if (empty($location)) {
            return redirect()->back()->withInput()->with('error', 'Please enter the Location of the job.');
        }
        if (!preg_match('/^[a-zA-Z0-9\s\,\.\-]+$/', $location)) {
            return redirect()->back()->withInput()->with('error', 'Location contains invalid characters.');
        }
        
        $deadline = $this->request->getPost('deadline');
        if (empty($deadline)) {
            return redirect()->back()->withInput()->with('error', 'Please set an Application Deadline.');
        }
        if (strtotime($deadline) < time()) {
            return redirect()->back()->withInput()->with('error', 'The Application Deadline must be a future date.');
        }

        if (empty($this->request->getPost('description'))) {
            return redirect()->back()->withInput()->with('error', 'Please provide a detailed Job Description.');
        }
        if (empty($this->request->getPost('requirements'))) {
            return redirect()->back()->withInput()->with('error', 'Please list the Job Requirements.');
        }

        $data = [
            'company_id'   => $this->company['id'],
            'category_id'  => $this->request->getPost('category_id'),
            'title'        => $this->request->getPost('title'),
            'slug'         => url_title($this->request->getPost('title') . '-' . uniqid(), '-', true),
            'description'  => $this->request->getPost('description'),
            'requirements' => $this->request->getPost('requirements'),
            'location'     => $this->request->getPost('location'),
            'type'         => $this->request->getPost('type'),
            'salary_min'   => $salaryMin,
            'salary_max'   => $salaryMax,
            'status'       => 'active',
            'level'        => $this->request->getPost('level'),
            'experience'   => $this->request->getPost('experience'),
            'education'    => $this->request->getPost('education'),
            'deadline'     => $deadline,
        ];

        if (!$jobModel->insert($data)) {
            // Should not happen given explicit checks, but as fallback
            return redirect()->back()->withInput()->with('error', 'System Error: Failed to save job. ' . implode(', ', $jobModel->errors()));
        }

        ActivityLogModel::log('Job Post', 'Company ' . $this->company['name'] . ' published a new job: ' . $data['title']);

        return redirect()->to('company')->with('success', 'Job published successfully!');
    }

    public function acceptApplication($id)
    {
        $applicationModel = new ApplicationModel();
        
        // Verify application belongs to this company's job
        $application = $applicationModel->select('applications.*')
            ->join('jobs', 'jobs.id = applications.job_id')
            ->where('jobs.company_id', $this->company['id'])
            ->where('applications.id', $id)
            ->first();

        if (!$application) {
            return redirect()->back()->with('error', 'Application not found or access denied.');
        }

        $applicationModel->update($id, ['status' => 'accepted']);
        // Here you could trigger a notification to the candidate
        
        return redirect()->back()->with('success', 'Application accepted successfully.');
    }

    public function rejectApplication($id)
    {
        $applicationModel = new ApplicationModel();

        // Verify application belongs to this company's job
        $application = $applicationModel->select('applications.*')
            ->join('jobs', 'jobs.id = applications.job_id')
            ->where('jobs.company_id', $this->company['id'])
            ->where('applications.id', $id)
            ->first();

        if (!$application) {
            return redirect()->back()->with('error', 'Application not found or access denied.');
        }

        $applicationModel->update($id, ['status' => 'rejected']);
        
        return redirect()->back()->with('success', 'Application rejected.');
    }

    public function applications()
    {
        $applicationModel = new ApplicationModel();
        $jobId = $this->request->getGet('job_id');
        
        $builder = $applicationModel->select('applications.*, jobs.title as job_title, candidates.full_name as candidate_name, candidates.location as candidate_location, candidates.bio as candidate_bio, candidates.resume_path')
            ->join('jobs', 'jobs.id = applications.job_id')
            ->join('candidates', 'candidates.id = applications.candidate_id')
            ->where('jobs.company_id', $this->company['id'])
            ->where('applications.status', 'pending');

        // Apply Filtering if Job ID is provided
        if ($jobId) {
             // Verify the job belongs to this company first (Implicitly handled by join 'jobs.company_id' check above, but adding logic for clarity is good)
             $builder->where('jobs.id', $jobId);
        }

        $applications = $builder->orderBy('applications.created_at', 'DESC')->findAll();

        $data = [
            'title'        => 'Applications - LibyanJobs',
            'applications' => $applications
        ];

        echo view('templates/header', $data);
        echo view('company/applications', $data);
        echo view('templates/footer');
    }
}
