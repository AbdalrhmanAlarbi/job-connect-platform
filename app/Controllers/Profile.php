<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\CandidateModel;
use App\Models\CompanyModel;

class Profile extends BaseController
{
    public function index($userId = null)
    {
        $session = session();
        $currentUserId = $session->get('user_id');
        $userId = $userId ?? $currentUserId;

        if (!$userId) {
            return redirect()->to('auth/login');
        }

        $userModel = new UserModel();
        $user = $userModel->find($userId);

        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $profileData = [];
        if ($user['role'] === 'candidate') {
            $candidateModel = new CandidateModel();
            $profileData = $candidateModel->where('user_id', $userId)->first();
        } elseif ($user['role'] === 'company') {
            $companyModel = new CompanyModel();
            $profileData = $companyModel->where('user_id', $userId)->first();
        }

        $data = [
            'title'   => ($userId == $currentUserId) ? 'My Profile' : $user['name'] . ' - Profile',
            'user'    => $user,
            'profile' => $profileData,
            'isOwner' => ($userId == $currentUserId)
        ];
        
        echo view('templates/header', $data);
        echo view('profile/index', $data);
        echo view('templates/footer');
    }

    public function update()
    {
        $session = session();
        $userId = $session->get('user_id');
        if (!$userId) return redirect()->to('auth/login');

        $userModel = new UserModel();
        $user = $userModel->find($userId);

        $name = $this->request->getPost('name');
        if(empty($name)) {
             return redirect()->back()->withInput()->with('error', 'Name cannot be empty.');
        }
        
        $userModel->update($userId, ['name' => $name]);
        $session->set('user_name', $name);

        if ($user['role'] === 'candidate') {
            $candidateModel = new CandidateModel();
            $candidate = $candidateModel->where('user_id', $userId)->first();
            
            // Conditional Validation: Cannot clear existing data
            $phone = $this->request->getPost('phone');
            $location = $this->request->getPost('location');
            $bio = $this->request->getPost('bio');

            if (!empty($candidate['phone']) && empty($phone)) {
                return redirect()->back()->withInput()->with('error', 'Phone number cannot be removed once set.');
            }
            if (!empty($candidate['location']) && empty($location)) {
                return redirect()->back()->withInput()->with('error', 'Location cannot be removed once set.');
            }
            if (!empty($candidate['bio']) && empty($bio)) {
                return redirect()->back()->withInput()->with('error', 'Bio cannot be removed once set.');
            }

            $updateData = [
                'full_name' => $name,
                'phone'     => $phone,
                'location'  => $location,
                'bio'       => $bio,
            ];

            $file = $this->request->getFile('cv_file');
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move(FCPATH . 'uploads/resumes', $newName);
                $updateData['resume_path'] = 'uploads/resumes/' . $newName;
            }

            // Candidate Logo Upload (Added)
            $logo = $this->request->getFile('logo');
            if ($logo && $logo->isValid() && !$logo->hasMoved()) {
                $newName = $logo->getRandomName();
                $logo->move(FCPATH . 'uploads/logos', $newName);
                $updateData['logo'] = $newName;
                
                // Update Session for Header
                $session->set('user_logo', $newName);
            }

            $candidateModel->update($candidate['id'], $updateData);
        } elseif ($user['role'] === 'company') {
            $companyModel = new CompanyModel();
            $company = $companyModel->where('user_id', $userId)->first();

            // Conditional Validation
            $location = $this->request->getPost('location');
            $website = $this->request->getPost('website');
            $description = $this->request->getPost('description');

            if (!empty($company['location']) && empty($location)) {
                return redirect()->back()->withInput()->with('error', 'Location cannot be removed once set.');
            }
            if (!empty($company['website']) && empty($website)) {
                return redirect()->back()->withInput()->with('error', 'Website cannot be removed once set.');
            }
            if (!empty($company['description']) && empty($description)) {
                return redirect()->back()->withInput()->with('error', 'Description cannot be removed once set.');
            }

            $updateData = [
                'name'        => $name,
                'location'    => $location,
                'website'     => $website,
                'description' => $description,
            ];

            $logo = $this->request->getFile('logo');
            if ($logo && $logo->isValid() && !$logo->hasMoved()) {
                $newName = $logo->getRandomName();
                $logo->move(FCPATH . 'uploads/logos', $newName);
                $updateData['logo'] = $newName;
                
                // Update Session for Header Display
                $session->set('user_logo', $newName);
            }

            $companyModel->update($company['id'], $updateData);
        }

        return redirect()->to('profile')->with('success', 'Profile updated successfully!');
    }

    public function changePassword()
    {
        $userId = session()->get('user_id');
        if (!$userId) return redirect()->to('auth/login');

        $userModel = new UserModel();
        $user = $userModel->find($userId);

        $newPassword = $this->request->getPost('new_password');
        $confirmPassword = $this->request->getPost('confirm_password');

        // Custom Error Messages for Empty Fields
        if (empty($newPassword)) {
            return redirect()->to('profile')->with('error', 'Please enter a New Password.');
        }
        
        if (empty($confirmPassword)) {
            return redirect()->to('profile')->with('error', 'Please confirm your New Password.');
        }

        // Match Check
        if ($newPassword !== $confirmPassword) {
            return redirect()->to('profile')->with('error', 'Passwords do not match. Please try again.');
        }

        // Length Check
        if (strlen($newPassword) < 8) {
            return redirect()->to('profile')->with('error', 'Password must be at least 8 characters long.');
        }

        // Complexity Check
        if (!preg_match('/[0-9]/', $newPassword)) {
             return redirect()->to('profile')->with('error', 'Password must contain at least one number.');
        }

        // Update with hash
        $userModel->update($userId, ['password' => password_hash($newPassword, PASSWORD_DEFAULT)]);
        
        return redirect()->to('profile')->with('success', 'Password updated successfully!');
    }
}
