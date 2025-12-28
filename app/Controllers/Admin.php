<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\CompanyModel;
use App\Models\JobModel;
use App\Models\CandidateModel;
use App\Models\ApplicationModel;
use App\Models\SettingModel;
use App\Models\ActivityLogModel;

class Admin extends BaseController
{
    private $pendingCount = 0;

    public function __construct()
    {
        // Simple Auth Check
        if (!session()->get('is_admin')) {
            header('Location: ' . base_url('auth/login'));
            exit;
        }

        $companyModel = new CompanyModel();
        $this->pendingCount = $companyModel->where('status', 'pending')->countAllResults();
    }

    public function index()
    {
        $userModel = new UserModel();
        $companyModel = new CompanyModel();
        $jobModel = new JobModel();
        $activityModel = new ActivityLogModel();

        $recentActivity = $activityModel->select('activity_log.*, users.name as user_name')
            ->join('users', 'users.id = activity_log.user_id', 'left')
            ->orderBy('activity_log.created_at', 'DESC')
            ->limit(10)
            ->findAll();

        $data = [
            'title' => 'Admin Dashboard - LibyanJobs',
            'stats' => [
                'users'             => $userModel->countAllResults(),
                'companies'         => $companyModel->where('status', 'approved')->countAllResults(),
                'pending_companies' => $this->pendingCount,
                'active_jobs'       => $jobModel->where('status', 'active')->countAllResults()
            ],
            'recentActivity' => $recentActivity
        ];
        echo view('admin/templates/header', $data);
        echo view('admin/dashboard', $data);
        echo view('templates/footer', ['hide_footer' => true]);
    }

    public function requests()
    {
        $companyModel = new CompanyModel();
        
        // Fetch pending companies. Use company.email since user record may not exist yet.
        $requests = $companyModel->where('status', 'pending')
            ->orderBy('created_at', 'DESC')
            ->findAll();

        $data = [
            'title'    => 'Company Verification Requests - LibyanJobs',
            'requests' => $requests,
            'stats'    => [
                'pending_companies' => $this->pendingCount
            ]
        ];
        echo view('admin/templates/header', $data);
        echo view('admin/requests', $data);
        echo view('templates/footer', ['hide_footer' => true]);
    }

    public function users()
    {
        $userModel = new UserModel();
        $searchQuery = $this->request->getGet('q');

        if (!empty($searchQuery)) {
            $userModel->groupStart()
                ->like('name', $searchQuery)
                ->orLike('email', $searchQuery)
                ->groupEnd();
        }

        $users = $userModel->orderBy('created_at', 'DESC')->findAll();

        $data = [
            'title'       => 'User Management',
            'users'       => $users,
            'searchQuery' => $searchQuery,
            'stats'       => [
                'pending_companies' => $this->pendingCount
            ]
        ];
        echo view('admin/templates/header', $data);
        echo view('admin/users', $data);
        echo view('templates/footer', ['hide_footer' => true]);
    }


    public function approveCompany($id)
    {
        $companyModel = new CompanyModel();
        $company = $companyModel->find($id);

        if (!$company) {
            return redirect()->to('admin/requests')->with('error', 'Company not found.');
        }

        // Create User record if it doesn't exist
        $userId = $company['user_id'];
        if (!$userId) {
            $userModel = new UserModel();
            
            // Check if user already exists (backup check)
            $existingUser = $userModel->where('email', $company['email'])->first();
            if ($existingUser) {
                $userId = $existingUser['id'];
            } else {
                if (!$userModel->insert([
                    'name'     => $company['name'],
                    'email'    => $company['email'],
                    'password' => $company['password'],
                    'role'     => 'company'
                ])) {
                    return redirect()->to('admin/requests')->with('error', 'Failed to create user account: ' . implode(', ', $userModel->errors()));
                }
                $userId = $userModel->getInsertID();
            }
        }

        $companyModel->update($id, [
            'status'  => 'approved',
            'user_id' => $userId
        ]);

        ActivityLogModel::log('Approve', 'Company ' . $company['name'] . ' has been approved and activated.');
        return redirect()->to('admin/requests')->with('success', 'Company Approved and Activated successfully.');
    }

    public function rejectCompany($id)
    {
        $companyModel = new CompanyModel();
        $companyModel->update($id, ['status' => 'rejected']);
        ActivityLogModel::log('Reject', 'Company ID ' . $id . ' has been rejected.');
        return redirect()->to('admin/requests')->with('error', 'Company Rejected.');
    }

    public function deleteUser($id)
    {
        $userModel = new UserModel();
        $userModel->delete($id);
        ActivityLogModel::log('Delete', 'User ID ' . $id . ' has been deleted.');
        return redirect()->to('admin/users')->with('success', 'User deleted successfully.');
    }

    public function deleteRequest($id)
    {
        $companyModel = new CompanyModel();
        $companyModel->delete($id);
        return redirect()->to('admin/requests')->with('success', 'Request deleted successfully.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}
