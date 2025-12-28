<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        // 15 realistic job categories with proper Font Awesome icons
        $data = [
            ['name' => 'Graphics & Design', 'icon' => 'fa-pen-nib'],
            ['name' => 'Code & Programming', 'icon' => 'fa-code'],
            ['name' => 'Digital Marketing', 'icon' => 'fa-bullhorn'],
            ['name' => 'Video & Animation', 'icon' => 'fa-video'],
            ['name' => 'Music & Audio', 'icon' => 'fa-music'],
            ['name' => 'Account & Finance', 'icon' => 'fa-chart-line'],
            ['name' => 'Health & Care', 'icon' => 'fa-user-doctor'],
            ['name' => 'Data & Science', 'icon' => 'fa-database'],
            ['name' => 'Sales & Business Development', 'icon' => 'fa-handshake'],
            ['name' => 'Education & Training', 'icon' => 'fa-graduation-cap'],
            ['name' => 'Engineering & Architecture', 'icon' => 'fa-building'],
            ['name' => 'Legal Services', 'icon' => 'fa-gavel'],
            ['name' => 'Customer Support', 'icon' => 'fa-headset'],
            ['name' => 'Human Resources', 'icon' => 'fa-users'],
            ['name' => 'Operations & Logistics', 'icon' => 'fa-truck'],
            ['name' => 'Writing & Translation', 'icon' => 'fa-pen-fancy'],
            ['name' => 'AI & Machine Learning', 'icon' => 'fa-robot'],
            ['name' => 'Lifestyle & Health', 'icon' => 'fa-heart-pulse'],
            ['name' => 'Photography & Videography', 'icon' => 'fa-camera'],
            ['name' => 'Cybersecurity & IT', 'icon' => 'fa-shield-halved'],
        ];

        // Using Query Builder
        $this->db->table('categories')->insertBatch($data);
    }
}
