<?php
namespace App\Controllers;

use App\Models\JobModel;
use App\Models\CategoryModel;
use App\Models\CompanyModel;

class Jobs extends BaseController
{
    public function index()
    {
        $jobModel = new JobModel();
        $categoryModel = new CategoryModel();

        $search = $this->request->getGet('search');
        $location = $this->request->getGet('location');
        $categories_filter = $this->request->getGet('category');
        $type_filter = $this->request->getGet('type');

        $query = $jobModel->select('jobs.*, companies.name as company_name, companies.logo as company_logo')
            ->join('companies', 'companies.id = jobs.company_id')
            ->where('jobs.status', 'active');

        if ($search) {
            $query->groupStart()
                ->like('jobs.title', $search)
                ->orLike('companies.name', $search)
                ->orLike('jobs.description', $search)
                ->groupEnd();
        }

        if ($location) {
            $query->like('jobs.location', $location);
        }

        if ($categories_filter) {
            $query->whereIn('jobs.category_id', $categories_filter);
        }

        if ($type_filter) {
            $query->whereIn('jobs.type', $type_filter);
        }

        $jobs = $query->orderBy('jobs.created_at', 'DESC')->paginate(10);
        $pager = $jobModel->pager;

        // Categories for sidebar
        $categories = $categoryModel->select('categories.*, COUNT(jobs.id) as job_count')
            ->join('jobs', 'jobs.category_id = categories.id AND jobs.status = "active"', 'left')
            ->groupBy('categories.id')
            ->findAll();

        $data = [
            'title'      => 'Find Jobs - LibyanJobs',
            'jobs'       => $jobs,
            'pager'      => $pager,
            'categories' => $categories,
            'search'     => $search,
            'location'   => $location,
            'selected_categories' => $categories_filter ?? [],
            'selected_types'      => $type_filter ?? []
        ];

        echo view('templates/header', $data);
        echo view('jobs/index', $data);
        echo view('templates/footer', $data);
    }

    public function details($id = null)
    {
        $jobModel = new JobModel();
        $companyModel = new CompanyModel();

        $job = $jobModel->select('jobs.*, companies.name as company_name, companies.logo as company_logo, companies.description as company_description, companies.website as company_website, companies.location as company_location')
            ->join('companies', 'companies.id = jobs.company_id')
            ->where('jobs.id', $id)
            ->first();

        if (!$job) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Fetch Related Jobs (same category)
        $relatedJobs = $jobModel->select('jobs.*, companies.name as company_name, companies.logo as company_logo')
            ->join('companies', 'companies.id = jobs.company_id')
            ->where('jobs.category_id', $job['category_id'])
            ->where('jobs.id !=', $id)
            ->where('jobs.status', 'active')
            ->limit(3)
            ->findAll();

        $data = [
            'title'        => $job['title'] . ' - LibyanJobs',
            'job'          => $job,
            'related_jobs' => $relatedJobs
        ];

        echo view('templates/header', $data);
        echo view('jobs/details', $data);
        echo view('templates/footer');
    }
}