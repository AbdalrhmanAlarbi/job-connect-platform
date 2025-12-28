<div style="background-color: #F8F9FA; min-height: 100vh; display: flex; width: 100%;">
        
        <!-- Sidebar -->
        <?= view('admin/templates/sidebar') ?>

        <!-- Main Content -->
        <div style="flex: 1; padding: 30px; min-width: 0;">
            <h1 style="font-size: 24px; font-weight: 700; margin-bottom: 30px; color: #1A1A1A;">Dashboard Overview</h1>
            
            <!-- Stats Grid -->
            <div class="grid-4" style="gap: 20px;">
                <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
                    <div style="color: #666; font-size: 14px; margin-bottom: 5px;">Total Candidates</div>
                    <div style="font-size: 28px; font-weight: 700; color: #1A1A1A;"><?= $stats['users'] ?></div>
                </div>
                 <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
                    <div style="color: #666; font-size: 14px; margin-bottom: 5px;">Active Companies</div>
                    <div style="font-size: 28px; font-weight: 700; color: #1A1A1A;"><?= $stats['companies'] ?></div>
                </div>
                 <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
                    <div style="color: #666; font-size: 14px; margin-bottom: 5px;">Pending Requests</div>
                    <div style="font-size: 28px; font-weight: 700; color: #dc3545;"><?= $stats['pending_companies'] ?></div>
                </div>
                 <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
                    <div style="color: #666; font-size: 14px; margin-bottom: 5px;">Active Jobs</div>
                    <div style="font-size: 28px; font-weight: 700; color: #28a745;"><?= $stats['active_jobs'] ?></div>
                </div>
            </div>

             <!-- Recent Activity (Dynamic) -->
            <div style="margin-top: 30px; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
                <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 25px; padding-bottom: 15px; border-bottom: 1px solid #eee;">Recent System Activity</h3>
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    <?php if(!empty($recentActivity)): ?>
                        <?php foreach($recentActivity as $act): ?>
                        <div style="display: flex; gap: 15px; align-items: start;">
                            <div style="width: 40px; height: 40px; background: #E8F1FF; color: var(--primary-color); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <?php 
                                    $icon = 'fa-circle-info';
                                    if(stripos($act['action'], 'delete') !== false) $icon = 'fa-trash-can';
                                    if(stripos($act['action'], 'approve') !== false) $icon = 'fa-check-circle';
                                    if(stripos($act['action'], 'register') !== false) $icon = 'fa-user-plus';
                                    if(stripos($act['action'], 'job') !== false) $icon = 'fa-briefcase';
                                ?>
                                <i class="fa-solid <?= $icon ?>"></i>
                            </div>
                            <div>
                                <div style="font-size: 14px; font-weight: 600; color: #333;"><?= esc($act['action']) ?>: <?= esc($act['description']) ?></div>
                                <div style="font-size: 12px; color: #888; margin-top: 2px;">
                                    <?= date('M d, H:i', strtotime($act['created_at'])) ?> by <?= esc($act['user_name'] ?? 'System') ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p style="color: #666; font-size: 14px;">No recent activity found.</p>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</div>
