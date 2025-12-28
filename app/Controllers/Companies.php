<?php
namespace App\Controllers;

use App\Models\CompanyModel;
use App\Models\JobModel;

class Companies extends BaseController
{
    public function index()
    {
        $companyModel = new CompanyModel();
        
        $search = $this->request->getGet('search');
        $location = $this->request->getGet('location');

        $query = $companyModel->select('companies.*, COUNT(jobs.id) as job_count')
            ->join('jobs', 'jobs.company_id = companies.id AND jobs.status = "active"', 'left')
            ->where('companies.status', 'approved')
            ->groupBy('companies.id');

        if ($search) {
            $query->like('companies.name', $search);
        }

        if ($location) {
            $query->like('companies.location', $location);
        }

        $companies = $query->orderBy('job_count', 'DESC')
            ->paginate(12);

        $data = [
            'title'     => 'Top Companies - LibyanJobs',
            'companies' => $companies,
            'pager'     => $companyModel->pager,
            'search'    => $search,
            'location'  => $location
        ];
        echo view('templates/header', $data);
        echo view('companies/index', $data);
        echo view('templates/footer');
    }

    public function details($id = null)
    {
        if (!$id) {
            return redirect()->to('companies');
        }

        $companyModel = new CompanyModel();
        $jobModel = new JobModel();

        $company = $companyModel->find($id);

        if (!$company || $company['status'] !== 'approved') {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Fetch Active Jobs for Company
        $jobs = $jobModel->where('company_id', $id)
                         ->where('status', 'active')
                         ->orderBy('created_at', 'DESC')
                         ->findAll();

        $data = [
            'title'   => $company['name'] . ' - LibyanJobs',
            'company' => $company,
            'jobs'    => $jobs
        ];

        echo view('templates/header', $data);
        echo view('companies/details', $data);
        echo view('templates/footer');
    }
}