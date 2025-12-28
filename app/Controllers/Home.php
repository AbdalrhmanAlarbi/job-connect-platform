<?php
namespace App\Controllers;

use App\Models\JobModel;
use App\Models\CompanyModel;
use App\Models\UserModel;
use App\Models\CategoryModel;

class Home extends BaseController
{
    public function index()
    {
        // Handle Search Redirect from Home Page
        $request = service('request');
        $search = $request->getGet('search');
        $location = $request->getGet('location');

        if ($search || $location) {
            return redirect()->to('jobs?search=' . urlencode($search) . '&location=' . urlencode($location));
        }

        $jobModel = new JobModel();
        $companyModel = new CompanyModel();
        $userModel = new UserModel();
        $categoryModel = new CategoryModel();

        // 1. Statistics
        $totalJobs = $jobModel->where('status', 'active')->countAllResults();
        $totalCompanies = $companyModel->where('status', 'approved')->countAllResults();
        $totalCandidates = $userModel->where('role', 'candidate')->countAllResults();

        // 2. Categories with Job Counts
        $cats = $categoryModel->select('categories.*, COUNT(jobs.id) as job_count')
            ->join('jobs', 'jobs.category_id = categories.id AND jobs.status = "active"', 'left')
            ->groupBy('categories.id')
            ->orderBy('job_count', 'DESC')
            ->limit(8)
            ->findAll();

        // 3. Popular Vacancies (Most frequent job titles)
        $popularVacancies = $jobModel->select('title, COUNT(*) as count')
            ->where('status', 'active')
            ->groupBy('title')
            ->orderBy('count', 'DESC')
            ->limit(8)
            ->findAll();

        // 4. Featured Jobs
        $recent_jobs = $jobModel->select('jobs.*, companies.name as company_name, companies.logo as company_logo')
            ->join('companies', 'companies.id = jobs.company_id')
            ->where('jobs.status', 'active')
            ->where('jobs.is_featured', 1)
            ->orderBy('jobs.created_at', 'DESC')
            ->limit(6)
            ->findAll();

        // 5. Top Companies
        $companies = $companyModel->select('companies.*, COUNT(jobs.id) as job_count')
            ->join('jobs', 'jobs.company_id = companies.id AND jobs.status = "active"', 'left')
            ->where('companies.status', 'approved')
            ->groupBy('companies.id')
            ->orderBy('job_count', 'DESC')
            ->limit(6)
            ->findAll();
                                     
        $data = [
            'cats'              => $cats,
            'companies'         => $companies,
            'recent_jobs'       => $recent_jobs,
            'popular_vacancies' => $popularVacancies,
            'total_jobs'        => $totalJobs,
            'total_companies'   => $totalCompanies,
            'total_candidates'  => $totalCandidates
        ];

        echo view('templates/header', $data);
        echo view('home', $data);
        echo view('templates/footer', $data);
    }
}