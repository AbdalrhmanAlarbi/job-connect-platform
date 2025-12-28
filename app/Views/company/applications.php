
<div style="background-color: #F8F9FA; min-height: 100vh; padding: 40px 0;">
    <div class="container">
        
        <div style="margin-bottom: 30px;">
           <a href="<?= base_url('company') ?>" style="display: inline-flex; align-items: center; gap: 8px; color: #666; text-decoration: none; font-weight: 500; font-size: 14px; padding: 8px 16px; background: #fff; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); transition: all 0.2s;">
               <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
           </a>
        </div>

        <div style="display: flex; flex-direction: column; gap: 20px;">
            <?php if(!empty($applications)): ?>
                <?php foreach ($applications as $app): ?>
                <!-- Application Card -->
                <div style="background: #fff; padding: 25px; border-radius: 12px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 4px 15px rgba(0,0,0,0.02); border: 1px solid #f0f0f0;">
                    
                    <div style="display: flex; align-items: center; gap: 20px;">
                        <!-- Avatar -->
                        <div style="width: 60px; height: 60px; border-radius: 50%; background: #333; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 24px;">
                             <!-- Mock Image for Visual Fidelity or Initials -->
                             <?php if(file_exists(FCPATH . 'assets/images/user-placeholder.png')): ?>
                                <img src="<?= base_url('assets/images/user-placeholder.png') ?>" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                             <?php else: ?>
                                <?= substr(esc($app['candidate_name']), 0, 1) ?>
                             <?php endif; ?>
                        </div>
                        
                        <!-- Info -->
                        <div>
                            <h4 style="font-size: 16px; font-weight: 700; margin: 0 0 8px 0; color: #1A1A1A;"><?= esc($app['candidate_name']) ?></h4>
                            <div style="display: flex; align-items: center; gap: 10px; font-size: 12px;">
                                <span style="background: #E8F5E9; color: #2E7D32; padding: 4px 10px; border-radius: 4px; font-weight: 700; text-transform: uppercase; font-size: 10px; letter-spacing: 0.5px;"><?= esc($app['job_title']) ?></span>
                                <span style="color: #999;">Time : <?= date('h:iA', strtotime($app['created_at'])) ?> to <?= date('h:iA', strtotime($app['created_at'] . ' + 8 hours')) ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Middle Info -->
                    <div style="text-align: left; min-width: 150px;">
                        <div style="font-weight: 600; font-size: 14px; color: #333; margin-bottom: 5px;">Google Inc.</div>
                        <div style="font-size: 13px; color: #888; display: flex; align-items: center; gap: 5px;">
                            <i class="fa-solid fa-location-dot" style="font-size: 11px;"></i> <?= esc($app['candidate_location']) ?>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 10px; min-width: 250px;">
                        <!-- Top Buttons: Approve / Reject -->
                        <div style="display: flex; gap: 10px; width: 100%;">
                            <?php if($app['status'] === 'pending'): ?>
                                <a href="<?= base_url('company/accept-application/'.$app['id']) ?>" style="flex: 1; text-align: center; background: #F0F9EB; color: #2E7D32; padding: 8px 0; border: none; border-radius: 4px; font-weight: 600; font-size: 13px; cursor: pointer; text-decoration: none;">Approve</a>
                                <a href="<?= base_url('company/reject-application/'.$app['id']) ?>" style="flex: 1; text-align: center; background: #FEF2F2; color: #DC2626; padding: 8px 0; border: none; border-radius: 4px; font-weight: 600; font-size: 13px; cursor: pointer; text-decoration: none;">Reject</a>
                            <?php elseif($app['status'] === 'accepted'): ?>
                                <div style="flex: 1; text-align: center; background: #F0F9EB; color: #2E7D32; padding: 8px 0; border-radius: 4px; font-weight: 600; font-size: 13px;">Approved</div>
                            <?php else: ?>
                                <div style="flex: 1; text-align: center; background: #FEF2F2; color: #DC2626; padding: 8px 0; border-radius: 4px; font-weight: 600; font-size: 13px;">Rejected</div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Bottom Button: Download CV -->
                        <?php if(!empty($app['resume_path'])): ?>
                        <a href="<?= base_url($app['resume_path']) ?>" target="_blank" style="background: #0056D2; color: white; border: none; padding: 10px 0; border-radius: 4px; font-weight: 500; font-size: 13px; cursor: pointer; width: 100%; text-align: center; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px;">
                            <i class="fa-solid fa-eye"></i> Show CV
                        </a>
                        <?php else: ?>
                             <button disabled style="background: #ccc; color: white; border: none; padding: 10px 0; border-radius: 4px; font-weight: 500; font-size: 13px; width: 100%; cursor: not-allowed;">No CV</button>
                        <?php endif; ?>
                    </div>

                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="text-align: center; padding: 50px; background: white; border-radius: 12px; border: 1px solid #eee;">
                    <h3>No applications yet</h3>
                    <p>When candidates apply for your jobs, they will appear here.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Pagination Mock -->
        <div style="display: flex; justify-content: center; margin-top: 50px; gap: 10px;">
             <a href="#" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; border-radius: 50%; background: #fff; color: #0066FF; text-decoration: none;"><i class="fa-solid fa-arrow-left"></i></a>
             <a href="#" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; border-radius: 50%; background: #0066FF; color: white; text-decoration: none; font-weight: 600;">01</a>
             <a href="#" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; border-radius: 50%; background: #fff; color: #666; text-decoration: none;">02</a>
             <a href="#" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; border-radius: 50%; background: #fff; color: #666; text-decoration: none;">03</a>
             <a href="#" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; border-radius: 50%; background: #fff; color: #666; text-decoration: none;">04</a>
             <a href="#" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; border-radius: 50%; background: #fff; color: #666; text-decoration: none;">05</a>
             <a href="#" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; border-radius: 50%; background: #E8F1FF; color: #0066FF; text-decoration: none;"><i class="fa-solid fa-arrow-right"></i></a>
        </div>

    </div>
</div>
