<?php
namespace App\Controllers;

use App\Models\UserModel;
use App\Models\CompanyModel;
use App\Models\CandidateModel;
use App\Models\ActivityLogModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('user_logged_in')) {
            return redirect()->to(session()->get('user_role') === 'company' ? 'company' : '/');
        }
        return view('auth/login');
    }

    public function signup()
    {
        if (session()->get('user_logged_in')) {
            return redirect()->to('/');
        }
        return view('auth/signup');
    }

    public function attemptLogin()
    {
        $userModel = new UserModel();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Explicit Validation for Mandatory Fields
        if (empty($email)) {
            return redirect()->back()->withInput()->with('error', 'Please enter your email address to log in.');
        }
        if (empty($password)) {
            return redirect()->back()->withInput()->with('error', 'Please enter your password to access your account.');
        }

        $user = $userModel->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {
            // Check if it's a company and if it's approved
            if ($user['role'] === 'company') {
                $companyModel = new CompanyModel();
                $company = $companyModel->where('user_id', $user['id'])->first();
                if (!$company || $company['status'] !== 'approved') {
                    $status = $company['status'] ?? 'pending';
                    $message = ($status === 'rejected') 
                        ? 'Access Denied: Your registration request has been rejected. This email cannot be used for application access.'
                        : 'Access Denied: Your company account is still in Pending state. You need to wait for admin approval.';
                    
                    ActivityLogModel::log('Login Denied', 'Company ' . $user['name'] . ' attempted login but status is ' . $status);
                    return redirect()->back()->withInput()->with('error', $message);
                }
            }

            $session = session();
            
            if ($user['role'] === 'admin') {
                $session->set('is_admin', true);
                $session->set([
                    'user_name' => $user['name'],
                    'user_role' => 'admin',
                    'user_logged_in' => true,
                    'user_id' => $user['id']
                ]);
                return redirect()->to('admin');
            }

            $sessionData = [
                'user_name' => $user['name'],
                'user_role' => $user['role'],
                'user_logged_in' => true,
                'user_id' => $user['id']
            ];

            if ($user['role'] === 'company' && isset($company['logo'])) {
                $sessionData['user_logo'] = $company['logo'];
            }
            // Logic for Candidates
             if ($user['role'] === 'candidate') {
                 $candidateModel = new CandidateModel();
                 $candidate = $candidateModel->where('user_id', $user['id'])->first();
                 if ($candidate && isset($candidate['logo'])) {
                      $sessionData['user_logo'] = $candidate['logo'];
                 }
            }

            $session->set($sessionData);

            ActivityLogModel::log('Login', 'User ' . $user['name'] . ' logged in.');

            return redirect()->to($user['role'] === 'company' ? 'company' : '/');
        }

        // Check if it's a company record (even if no user record exists yet)
        $companyModel = new CompanyModel();
        $companyRecord = $companyModel->where('email', $email)->first();
        if ($companyRecord) {
            if (password_verify($password, $companyRecord['password'])) {
                if ($companyRecord['status'] === 'rejected') {
                    return redirect()->back()->withInput()->with('error', 'Access Denied: Your registration request has been rejected. This email cannot be used for application access.');
                }
                return redirect()->back()->withInput()->with('error', 'Access Denied: Your company account is still in pending state. You need to wait for admin approval.');
            }
        }

        return redirect()->back()->withInput()->with('error', 'Login Failed: The email or password you entered is incorrect. Please check your credentials and try again.');
    }

    public function attemptSignup()
    {
        $role = $this->request->getPost('account_type') ?? 'candidate';
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $confirmPassword = $this->request->getPost('confirm_password');
        $name = $this->request->getPost('full_name');
        
        // Role-Specific Validation
        if ($role === 'company') {
            // Strict Validation for Companies
            if (empty($name)) {
                return redirect()->back()->withInput()->with('error', 'Please enter your Company Name.');
            }
            if (empty($email)) {
                return redirect()->back()->withInput()->with('error', 'A business email address is required.');
            }
            if (empty($this->request->getPost('phone'))) {
                return redirect()->back()->withInput()->with('error', 'Please provide a contact phone number.');
            }
            if (empty($this->request->getPost('location'))) {
                return redirect()->back()->withInput()->with('error', 'Please specify the company location.');
            }
            if (empty($this->request->getPost('website_url'))) {
                return redirect()->back()->withInput()->with('error', 'A website URL is required for verification.');
            }
            if (empty($password)) {
                return redirect()->back()->withInput()->with('error', 'Create a password for your company account.');
            }
            if (empty($confirmPassword)) {
                return redirect()->back()->withInput()->with('error', 'Please confirm your password.');
            }
            if ($password !== $confirmPassword) {
                return redirect()->back()->withInput()->with('error', 'Password mismatch: The passwords do not match.');
            }
        } else {
            // Existing Validation for Candidates (Unchanged)
            if (empty($name)) {
                return redirect()->back()->withInput()->with('error', 'Please enter your full name to proceed with the registration.');
            }
            if (empty($email)) {
                return redirect()->back()->withInput()->with('error', 'An email address is required to create your account.');
            }
            if (empty($password)) {
                return redirect()->back()->withInput()->with('error', 'Please set a password to secure your account.');
            }
            if (empty($confirmPassword)) {
                return redirect()->back()->withInput()->with('error', 'Please confirm your password to ensure they match.');
            }
            if ($password !== $confirmPassword) {
                return redirect()->back()->withInput()->with('error', 'Password mismatch: The passwords you entered do not match. Please try again.');
            }
        }

        $userModel = new UserModel();
        $companyModel = new CompanyModel();

        // 1. Check if email exists in companies table (Pending or Rejected)
        $existingCompany = $companyModel->where('email', $email)->first();
        if ($existingCompany) {
            if ($existingCompany['status'] === 'rejected') {
                return redirect()->back()->withInput()->with('error', 'Registration Rejected: This email cannot be used as it was previously rejected.');
            }
            if ($existingCompany['status'] === 'pending') {
                return redirect()->back()->withInput()->with('error', 'Registration Pending: A request with this email is already awaiting admin approval.');
            }
        }

        // 2. Check if email already exists in users table (Approved companies or Candidates)
        $user = $userModel->where('email', $email)->first();
        if ($user) {
            $message = ($user['role'] === 'company') 
                ? 'Account Active: This company registration is already approved and active. Please log in.'
                : 'Account Taken: This email is already registered to a candidate. Please log in.';
            return redirect()->back()->withInput()->with('error', $message);
        }

        if ($role === 'company') {
            $companyModel->insert([
                'name'     => $name,
                'email'    => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'location' => $this->request->getPost('location'),
                'website'  => $this->request->getPost('website_url'),
                'status'   => 'pending'
            ]);

            ActivityLogModel::log('Signup Request', 'New company ' . $name . ' requested registration.');
            return redirect()->to('/')->with('pending_signup', true);
        } else {
            // Candidate signup
            $userData = [
                'name'     => $name,
                'email'    => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'role'     => 'candidate',
            ];

            if (!$userModel->insert($userData)) {
                return redirect()->back()->withInput()->with('errors', $userModel->errors());
            }

            $userId = $userModel->getInsertID();
            $candidateModel = new CandidateModel();
            $candidateModel->insert([
                'user_id'   => $userId,
                'full_name' => $name,
                'location'  => $this->request->getPost('location'),
            ]);

            session()->set([
                'user_name' => $name,
                'user_role' => 'candidate',
                'user_logged_in' => true,
                'user_id' => $userId
            ]);

            ActivityLogModel::log('Signup', 'New user ' . $name . ' registered as candidate');
            return redirect()->to('/');
        }
    }

    public function pending()
    {
        return view('auth/pending');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}