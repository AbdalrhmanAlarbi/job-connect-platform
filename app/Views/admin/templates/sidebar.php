<div style="width: 280px; background: white; height: 100vh; padding: 25px; border-right: 1px solid #E5E7EB; display: flex; flex-direction: column; box-shadow: 2px 0 20px rgba(0,0,0,0.02); position: sticky; top: 0; z-index: 10; overflow-y: auto;">
    
    <!-- Header -->
    <div style="margin-bottom: 40px; padding: 0 10px;">
        <div style="font-weight: 800; font-size: 22px; color: #111827; display: flex; align-items: center; gap: 12px;">
            <div style="width: 32px; height: 32px; background: var(--primary-color); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white;">
                <i class="fa-solid fa-shield-halved" style="font-size: 16px;"></i>
            </div>
            <span>Admin</span>
        </div>
    </div>
    
    <nav style="display: flex; flex-direction: column; gap: 12px;">
        <div style="font-size: 11px; font-weight: 700; color: #9CA3AF; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 10px; padding-left: 12px;">Main Menu</div>

        <a href="<?= base_url('admin') ?>" 
           style="display: flex; align-items: center; padding: 12px 16px; border-radius: 8px; text-decoration: none; font-size: 14px; font-weight: 600; 
                  color: <?= url_is('admin') ? 'var(--primary-color)' : '#4B5563' ?>; 
                  background: <?= url_is('admin') ? '#E8F1FF' : 'transparent' ?>; 
                  transition: all 0.2s;"
           onmouseover="this.style.background='<?= url_is('admin') ? '#E8F1FF' : '#F3F4F6' ?>'" 
           onmouseout="this.style.background='<?= url_is('admin') ? '#E8F1FF' : 'transparent' ?>'">
            <i class="fa-solid fa-house" style="width: 24px; text-align: center; margin-right: 8px;"></i> 
            <span style="flex: 1;">Overview</span>
        </a>

        <!-- Company Requests -->
        <a href="<?= base_url('admin/requests') ?>" 
           style="display: flex; align-items: center; padding: 12px 16px; border-radius: 8px; text-decoration: none; font-size: 14px; font-weight: 600; 
                  color: <?= url_is('admin/requests') ? 'var(--primary-color)' : '#4B5563' ?>; 
                  background: <?= url_is('admin/requests') ? '#E8F1FF' : 'transparent' ?>; 
                  transition: all 0.2s;"
           onmouseover="this.style.background='<?= url_is('admin/requests') ? '#E8F1FF' : '#F3F4F6' ?>'" 
           onmouseout="this.style.background='<?= url_is('admin/requests') ? '#E8F1FF' : 'transparent' ?>'">
            <i class="fa-solid fa-building-circle-check" style="width: 24px; text-align: center; margin-right: 8px;"></i> 
            <span style="flex: 1;">Requests</span>
            <?php if(isset($stats['pending_companies']) && $stats['pending_companies'] > 0): ?>
            <span style="
    background: #EF4444;
    color: white;
    font-size: 10px;
    font-weight: 700;
    padding: 2px 8px;
    border-radius: 999px;
    min-width: 18px;
    text-align: center;
">
    <?= $stats['pending_companies'] ?>
</span>
<?php endif; ?>
        </a>

        <!-- User Management -->
        <a href="<?= base_url('admin/users') ?>" 
           style="display: flex; align-items: center; padding: 12px 16px; border-radius: 8px; text-decoration: none; font-size: 14px; font-weight: 600; 
                  color: <?= url_is('admin/users') ? 'var(--primary-color)' : '#4B5563' ?>; 
                  background: <?= url_is('admin/users') ? '#E8F1FF' : 'transparent' ?>; 
                  transition: all 0.2s;"
           onmouseover="this.style.background='<?= url_is('admin/users') ? '#E8F1FF' : '#F3F4F6' ?>'" 
           onmouseout="this.style.background='<?= url_is('admin/users') ? '#E8F1FF' : 'transparent' ?>'">
            <i class="fa-solid fa-users-gear" style="width: 24px; text-align: center; margin-right: 8px;"></i> 
            <span style="flex: 1;">Users</span>
        </a>

       
    </nav>

    <div style="margin-top: auto;">
        <div style="border-top: 1px solid #E5E7EB; margin: 20px 0;"></div>
        <a href="<?= base_url('admin/logout') ?>" 
           style="display: flex; align-items: center; padding: 12px 16px; color: #DC2626; text-decoration: none; font-weight: 600; font-size: 14px; border-radius: 8px; transition: background 0.2s;"
           onmouseover="this.style.background='#FEF2F2'" 
           onmouseout="this.style.background='transparent'">
            <i class="fa-solid fa-arrow-right-from-bracket" style="width: 24px; text-align: center; margin-right: 8px;"></i> Logout
        </a>
    </div>
</div>
