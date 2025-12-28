<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= lang('App.login') ?> - LibyanJobs</title>
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
        <div class="auth-card auth-card-login">
            <!-- Left Side (Blue) -->
            <div class="auth-side-blue">
                <div class="auth-content-box">
                    <h2><?= lang('App.auth_welcome_title') ?></h2>
                    <p><?= lang('App.auth_welcome_desc') ?></p>
                    
                  
                </div>
            </div>
            <!-- Right Side (Form) -->
            <div class="auth-side-form">
                <h2><?= lang('App.login') ?></h2>
                
                <?php if(session()->getFlashdata('error')): ?>
                    <div style="background: #FEE2E2; color: #991B1B; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 13px; border: 1px solid #FECACA; font-weight: 500;">
                        <i class="fa-solid fa-circle-exclamation" style="margin-right: 8px;"></i><?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <?php if(session()->getFlashdata('success')): ?>
                    <div style="background: #D1FAE5; color: #065F46; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 13px; border: 1px solid #A7F3D0; font-weight: 500;">
                        <i class="fa-solid fa-circle-check" style="margin-right: 8px;"></i><?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>
                <form action="<?= base_url('auth/attemptLogin') ?>" method="POST">
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <label><?= lang('App.email') ?></label>
                        <input type="email" name="email" value="<?= old('email') ?>" placeholder="">
                    </div>
                    <div class="form-group">
                        <label><?= lang('App.password') ?></label>
                        <div class="password-wrapper">
                            <input type="password" name="password" placeholder="">
                            <i class="fa-solid fa-eye password-toggle" onclick="togglePasswordVisibility(this)"></i>
                        </div>
                    </div>
                    
                    <button type="submit" class="auth-btn"><?= lang('App.login') ?></button>
                    
                    <div class="auth-footer-link">
                        <?= lang('App.dont_have_account') ?> <a href="<?= base_url('auth/signup') ?>"><?= lang('App.signup_here') ?></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="<?= base_url('assets/js/main.js?v=' . time()) ?>"></script>
</body>
</html>