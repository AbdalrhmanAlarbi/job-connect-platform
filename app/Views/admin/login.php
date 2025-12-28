
<div style="background: #F8F9FA; min-height: 100vh; display: flex; align-items: center; justify-content: center;">
    <div style="width: 100%; max-width: 400px; padding: 20px;">
        
        <div style="text-align: center; margin-bottom: 30px;">
            <div style="font-size: 24px; font-weight: 800; color: #1A1A1A; margin-bottom: 10px;">
                <i class="fa-solid fa-lock" style="color: var(--primary-color);"></i> Admin Panel
            </div>
            <div style="color: #666;">Please login to access the dashboard</div>
        </div>

        <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
            
            <?php if(session()->getFlashdata('error')): ?>
                <div style="background: #F8D7DA; color: #721C24; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; text-align: center;">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('admin/auth') ?>" method="post">
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #333;">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="admin" required style="width: 100%; padding: 12px; border: 1px solid #eee; border-radius: 8px; font-size: 14px;">
                </div>
                
                <div style="margin-bottom: 25px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #333;">Password</label>
                    <div class="password-wrapper">
                        <input type="password" name="password" class="form-control" placeholder="admin123" required style="width: 100%; padding: 12px; border: 1px solid #eee; border-radius: 8px; font-size: 14px;">
                        <i class="fa-solid fa-eye password-toggle" onclick="togglePasswordVisibility(this)"></i>
                    </div>
                </div>

                <button type="submit" style="width: 100%; background: var(--primary-color); color: white; padding: 14px; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: opacity 0.2s;">
                    Login to Dashboard
                </button>
            </form>

        </div>
</div>
<script src="<?= base_url('assets/js/main.js?v=' . time()) ?>"></script>
</body>
</html>
