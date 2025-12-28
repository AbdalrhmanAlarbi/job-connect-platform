<?php

namespace App\Controllers;

use App\Models\ApplicationModel;
use App\Models\CandidateModel;
use App\Models\ActivityLogModel;

class Applications extends BaseController
{
    public function apply()
    {
        $session = session();
        
        // 1. Check if user is logged in
        if (!$session->get('user_logged_in')) {
            return redirect()->to('auth/login')->with('error', 'You must be logged in to apply.');
        }

        // 2. Check if user is a candidate
        if ($session->get('user_role') !== 'candidate') {
            return redirect()->back()->with('error', 'Only candidates can apply for jobs.');
        }

        $userId = $session->get('user_id');
        $jobId = $this->request->getPost('job_id');

        if (!$jobId) {
            return redirect()->back()->with('error', 'Invalid job.');
        }

        // Get Candidate ID and check for CV
        $candidateModel = new CandidateModel();
        $candidate = $candidateModel->where('user_id', $userId)->first();

        if (!$candidate) {
            return redirect()->back()->with('error', 'Candidate profile not found.');
        }

        // Check for CV (Physical file existence)
        if (empty($candidate['resume_path']) || !file_exists(FCPATH . $candidate['resume_path'])) {
             return redirect()->to('profile')->with('error', 'You must upload a valid CV (Resume) in your profile before applying. Your current file seems to be missing or invalid.');
        }

        $applicationModel = new ApplicationModel();
        
        // 3. Check if already applied
        $existing = $applicationModel->where('job_id', $jobId)
                                     ->where('candidate_id', $candidate['id'])
                                     ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'You have already applied for this job.');
        }

        // 4. Create Application
        $applicationModel->insert([
            'job_id'       => $jobId,
            'candidate_id' => $candidate['id'],
            'status'       => 'pending'
        ]);

        ActivityLogModel::log('Application', 'User ' . $session->get('user_name') . ' applied for Job ID ' . $jobId);

        return redirect()->back()->with('success', 'Application submitted successfully!');
    }
}
