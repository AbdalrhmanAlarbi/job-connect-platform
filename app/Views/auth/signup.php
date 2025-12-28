<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= lang('App.signup') ?> - LibyanJobs</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css?v=' . time()) ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="auth-body">
    <div class="auth-wrapper">
        <div class="auth-logo-top">
            <a href="<?= base_url('/') ?>" style="color: white; text-decoration: none; display: flex; align-items: center; gap: 10px;">
                <img src="<?= base_url('assets/images/uploaded_image_1765372954783.png') ?>" alt="LibyanJobs">
                <span>LIBYANJOBS</span>
            </a>
        </div>
        <div class="auth-card auth-card-signup" id="authCard">
            <!-- Left Side (Blue) -->
            <div class="auth-side-blue">
                <div class="auth-content-box">
                    <h2><?= lang('App.auth_welcome_title') ?></h2>
                    <p><?= lang('App.auth_welcome_desc') ?></p>
                    
                </div>
            </div>
            <!-- Right Side (Form) -->
            <div class="auth-side-form">
                <h2><?= lang('App.create_account') ?></h2>

                <form action="<?= base_url('auth/attemptSignup') ?>" method="POST" id="signupForm">
                    <?= csrf_field() ?>
                    <div class="form-group" style="margin-bottom: 20px;">
                        <label style="margin-bottom: 10px; display:block;"><?= lang('App.account_type') ?></label>
                        <div style="display: flex; gap: 15px;">
                            <label style="cursor: pointer; display: flex; align-items: center; gap: 8px; font-weight: 500; background: #f8f9fa; padding: 8px 15px; border-radius: 8px; border: 1px solid #eee; font-size: 13px;">
                                <input type="radio" name="account_type" value="candidate" <?= old('account_type', 'candidate') === 'candidate' ? 'checked' : '' ?> onchange="toggleFields()" style="width: auto; margin: 0;"> 
                                <?= lang('App.candidate') ?>
                            </label>
                            <label style="cursor: pointer; display: flex; align-items: center; gap: 8px; font-weight: 500; background: #f8f9fa; padding: 8px 15px; border-radius: 8px; border: 1px solid #eee; font-size: 13px;">
                                <input type="radio" name="account_type" value="company" <?= old('account_type') === 'company' ? 'checked' : '' ?> onchange="toggleFields()" style="width: auto; margin: 0;"> 
                                <?= lang('App.company') ?>
                            </label>
                        </div>
                    </div>

                    <div id="errorContainer">
                        <?php if(session()->getFlashdata('error')): ?>
                            <div style="background: #FEE2E2; color: #991B1B; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 13px; border: 1px solid #FECACA; font-weight: 500;">
                                <i class="fa-solid fa-circle-exclamation" style="margin-right: 8px;"></i><?= session()->getFlashdata('error') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div class="form-group">
                            <label id="nameLabel"><?= old('account_type') === 'company' ? 'Company Name' : 'Full Name' ?></label>
                            <input type="text" name="full_name" id="nameInput" placeholder="<?= old('account_type') === 'company' ? 'e.g. Tech Solutions Ltd' : 'e.g. Sophie Thatcher' ?>" value="<?= old('full_name') ?>">
                        </div>

                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" name="email" placeholder="name@example.com" value="<?= old('email') ?>">
                        </div>

                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="text" name="phone" placeholder="+218 ..." value="<?= old('phone') ?>">
                        </div>

                        <div class="form-group">
                            <label>Location / City</label>
                            <input type="text" name="location" placeholder="Tripoli, Libya" value="<?= old('location') ?>">
                        </div>

                        <div class="form-group">
                            <label><?= lang('App.password') ?></label>
                            <div class="password-wrapper">
                                <input type="password" name="password" value="<?= old('password') ?>" placeholder="">
                                <i class="fa-solid fa-eye password-toggle" onclick="togglePasswordVisibility(this)"></i>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Confirm Password</label>
                            <div class="password-wrapper">
                                <input type="password" name="confirm_password" value="<?= old('confirm_password') ?>" placeholder="">
                                <i class="fa-solid fa-eye password-toggle" onclick="togglePasswordVisibility(this)"></i>
                            </div>
                        </div>

                        <div class="form-group" id="urlField" style="display: <?= old('account_type') === 'company' ? 'block' : 'none' ?>; grid-column: span 2;">
                            <label>Website URL</label>
                            <input type="url" name="website_url" placeholder="https://example.com" value="<?= old('website_url') ?>" style="width: 100%;">
                        </div>
                    </div>
                    
                    <button type="submit" class="auth-btn" style="margin-top: 20px;"><?= lang('App.create_account') ?></button>
                    
                    <div class="auth-footer-link">
                        <?= lang('App.already_have_account') ?> <a href="<?= base_url('auth/login') ?>"><?= lang('App.login') ?></a>
                    </div>
                </form>

                <script>
                    function toggleFields() {
                        const isCompany = document.querySelector('input[name="account_type"][value="company"]').checked;
                        const nameLabel = document.getElementById('nameLabel');
                        const nameInput = document.getElementById('nameInput');
                        const urlField = document.getElementById('urlField');
                        const authCard = document.getElementById('authCard');
                        const errorContainer = document.getElementById('errorContainer');
                        const form = document.getElementById('signupForm');
                        
                        // Clear error message when switching types
                        errorContainer.innerHTML = '';
                        
                        // Reset all inputs except the radio buttons
                        const inputs = form.querySelectorAll('input:not([type="radio"]):not([type="hidden"])');
                        inputs.forEach(input => input.value = '');

                        if (isCompany) {
                            nameLabel.textContent = 'Company Name';
                            nameInput.placeholder = 'e.g. Tech Solutions Ltd';
                            urlField.style.display = 'block';
                            authCard.classList.add('company-active');
                        } else {
                            nameLabel.textContent = 'Full Name';
                            nameInput.placeholder = 'e.g. Sophie Thatcher';
                            urlField.style.display = 'none';
                            authCard.classList.remove('company-active');
                        }
                    }
                </script>
            </div>
        </div>
    </div>
    <script src="<?= base_url('assets/js/main.js?v=' . time()) ?>"></script>
</body>
</html>