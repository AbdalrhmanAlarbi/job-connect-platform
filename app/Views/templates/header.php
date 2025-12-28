<?php
$lang_code = 'en';
$dir = 'ltr';
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'LibyanJobs') ?></title>
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">

</head>
<body style="background-color: #F8F9FA;">
    <!-- Header -->
    <header>
        <div class="container">
            <nav>
                <div class="logo" style="display: flex; align-items: center; gap: 20px;">
                     <!-- Assuming one of the images is the logo. Using a placeholder class if image is missing/wrong. -->
                    <a href="<?= base_url('/') ?>"><img src="<?= base_url('assets/images/uploaded_image_1765370406698.png') ?>" alt="LibyanJobs Logo" onerror="this.src='https://placehold.co/150x50?text=LibyanJobs'"></a>
                </div>

                <!-- Centered Post Job Button -->
                <?php if (url_is('company*') || (session()->get('user_logged_in') && session()->get('user_role') === 'company')): ?>
                <div style="flex-grow: 1; display: flex; justify-content: center;">
                    <a href="<?= base_url('company/post-job') ?>" class="btn btn-primary" style="padding: 10px 25px; font-size: 15px; font-weight: 600; box-shadow: 0 4px 10px rgba(59, 130, 246, 0.3);">
                         Post a Job
                    </a>
                </div>
                <?php endif; ?>

                <!-- Hide Standard Nav Links for Company -->
                <?php if (!url_is('company*') && !(session()->get('user_logged_in') && session()->get('user_role') === 'company')): ?>
                <ul class="nav-links">
                    <li><a href="<?= base_url('/') ?>" class="<?= url_is('/') ? 'active' : '' ?>">Home</a></li>
                    <li><a href="<?= base_url('jobs') ?>" class="<?= url_is('jobs') ? 'active' : '' ?>">Find Jobs</a></li>
                    <li><a href="<?= base_url('companies') ?>" class="<?= url_is('companies') ? 'active' : '' ?>">Companies</a></li>
                </ul>
                <?php else: ?>
                    <!-- Spacer if needed to balance layout when button is centered, though flex-grow on button container handles most -->
                    <?php if(!url_is('company*')): ?>
                     <div style="flex-grow: 1;"></div>
                    <?php endif; ?>
                <?php endif; ?>

                <div class="auth-buttons" style="display: flex; align-items: center; gap: 20px;">
                    <?php if(session()->get('user_logged_in')): ?>
                    
                    <!-- User Profile Dropdown -->
                    <div class="user-profile-dropdown" style="position: relative;">
                        <button onclick="toggleProfileDropdown()" style="background: none; border: none; cursor: pointer; display: flex; align-items: center; gap: 10px; padding: 0;">
                            <?php 
                            $userLogo = session()->get('user_logo');
                            $logoPath = $userLogo ? base_url('uploads/logos/' . $userLogo) : 'https://i.pravatar.cc/150?u=' . session()->get('user_id');
                            ?>
                            <img src="<?= $logoPath ?>" alt="Profile" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 1px solid #ddd;">
                            <div style="text-align: left; display: none; @media(min-width: 768px){display: block;}">
                                <div style="font-weight: 700; font-size: 14px; color: #333;"><?= esc(session()->get('user_name')) ?></div>
                                <div style="font-size: 11px; color: #888; text-transform: uppercase;"><?= esc(session()->get('user_role')) ?></div>
                            </div>
                            <i class="fa-solid fa-chevron-down" style="font-size: 12px; color: #888;"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div id="profileDropdownMenu" style="display: none; position: absolute; top: 100%; right: 0; margin-top: 10px; background: white; min-width: 200px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border: 1px solid #eee; z-index: 1000; overflow: hidden;">
                            <a href="<?= base_url('profile') ?>" style="display: block; padding: 12px 20px; color: #333; text-decoration: none; border-bottom: 1px solid #f5f5f5; font-size: 14px; transition: background 0.2s;">
                                <i class="fa-regular fa-user" style="margin-right: 10px; color: #888;"></i> My Profile
                            </a>
                            <a href="<?= base_url('auth/logout') ?>" style="display: block; padding: 12px 20px; color: #dc3545; text-decoration: none; font-size: 14px; transition: background 0.2s;">
                                <i class="fa-solid fa-arrow-right-from-bracket" style="margin-right: 10px;"></i> Log Out
                            </a>
                        </div>
                    </div>

                    <script>
                        function toggleProfileDropdown() {
                            var menu = document.getElementById('profileDropdownMenu');
                            if (menu.style.display === 'none' || menu.style.display === '') {
                                menu.style.display = 'block';
                            } else {
                                menu.style.display = 'none';
                            }
                        }

                        // Close dropdown when clicking outside
                        window.onclick = function(event) {
                            if (!event.target.closest('.user-profile-dropdown')) {
                                document.getElementById('profileDropdownMenu').style.display = 'none';
                            }
                        }
                    </script>

                    <?php else: ?>
                    <!-- Auth Buttons -->
                    <a href="<?= base_url('auth/login') ?>" class="btn btn-outline">Login</a>
                    <a href="<?= base_url('auth/signup') ?>" class="btn btn-primary">Signup</a> 
                    <?php endif; ?>
                </div>
            </nav>
        </div>
    </header>