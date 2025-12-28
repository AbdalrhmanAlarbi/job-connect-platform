
    <!-- Page Header -->
    <div class="page-header" style="background:#F2F2F2; padding: 40px 0;">
        <div class="container" style="display: flex; justify-content: space-between; align-items: center;">
            <h2 style="font-size: 24px; font-weight: 600;"><?= lang('App.job_details') ?></h2>
            
        </div>
    </div>
    <!-- Job Details Content -->
    <div class="container" style="padding: 50px 0;">
        <div class="job-details-grid">
            
            <!-- Left Column: Description -->
            <div class="job-info-col">
                <div class="job-header-box">
                    <div style="width: 60px; height: 60px; background: #eee; border-radius: 50%; display:flex; align-items:center; justify-content:center; font-weight:bold; font-size:20px; color:#555; overflow:hidden;">
                        <?php if(!empty($job['company_logo'])): ?>
                            <img src="<?= $job['company_logo'] ?>" style="width:100%; height:100%; object-fit:cover;">
                        <?php else: ?>
                            <i class="fa-solid fa-building"></i>
                        <?php endif; ?>
                    </div>
                    <div style="flex: 1;">
                        <h1 style="font-size: 24px; font-weight: 700; margin-bottom: 5px;"><?= esc($job['title']) ?></h1>
                        <div style="font-size: 14px; color: #666; display: flex; gap: 10px; align-items: center;">
                            <span>at <a href="<?= base_url('companies/details/' . $job['company_id']) ?>" style="color: #666; text-decoration: none; font-weight: 600;"><?= esc($job['company_name']) ?></a></span>
                            <span class="badge badge-success"><?= esc($job['type']) ?></span>
                            <?php if($job['is_featured']): ?>
                            <span class="badge badge-danger">Featured</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="action-buttons-desktop">

                         <form action="<?= base_url('applications/apply') ?>" method="post" style="display:inline;">
                             <input type="hidden" name="job_id" value="<?= $job['id'] ?>">
                             <button type="submit" class="btn btn-primary"><?= lang('App.apply_now') ?> <i class="fa-solid fa-arrow-right"></i></button>
                         </form>
                    </div>
                </div>
                
                <!-- Flash Messages -->
                <?php if(session()->getFlashdata('success')): ?>
                    <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>
                <?php if(session()->getFlashdata('error')): ?>
                    <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>
                <div class="content-block">
                    <h3><?= lang('App.job_description') ?></h3>
                    <div style="line-height: 1.6; color: #555;">
                        <?= nl2br(esc($job['description'])) ?>
                    </div>
                </div>
                
                <?php if(!empty($job['company_description'])): ?>
                <div class="content-block">
                    <h3><?= lang('App.about_company') ?></h3>
                    <p><?= nl2br(esc($job['company_description'])) ?></p>
                </div>
                <?php endif; ?>

                <!-- Related Jobs -->
                <?php if(!empty($related_jobs)): ?>
                <div class="content-block">
                    <h3><?= lang('App.related_jobs') ?></h3>
                    <div class="grid-1" style="gap: 20px;">
                        <?php foreach($related_jobs as $rJob): ?>
                        <div class="job-card" onclick="window.location.href='<?= base_url('jobs/details/'.$rJob['id']) ?>'" style="cursor: pointer; padding: 20px; border: 1px solid #eee;">
                            <div class="job-header">
                                <h4 style="font-size: 16px; margin:0;"><?= esc($rJob['title']) ?></h4>
                                <span class="job-type" style="font-size: 12px;"><?= esc($rJob['type']) ?></span>
                            </div>
                            <div style="font-size: 13px; color: #666; margin-top: 5px;">
                                <?= esc($rJob['company_name']) ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <!-- Right Column: Sidebar -->
            <div class="job-sidebar-col">
                <!-- Salary Card -->
                <div class="sidebar-card">
                    <div style="display: flex; gap: 20px; align-items: center; justify-content: space-around; text-align: center;">
                         <div>
                             <div style="font-size: 13px; color: #666; margin-bottom: 5px;">Salary (USD)</div>
                             <div style="font-size: 18px; font-weight: 700; color: #2ED480;">
                                 <?php if($job['salary_min']): ?>
                                    $<?= number_format($job['salary_min']) ?> - $<?= number_format($job['salary_max']) ?>
                                 <?php else: ?>
                                    Negotiable
                                 <?php endif; ?>
                             </div>
                             <div style="font-size: 12px; color: #999;">Yearly salary</div>
                         </div>
                         <div style="width: 1px; height: 50px; background: #EEE;"></div>
                         <div>
                             <div style="font-size: 24px; color: var(--primary-color); margin-bottom: 5px;"><i class="fa-solid fa-location-dot"></i></div>
                             <div style="font-size: 14px; font-weight: 600;"><?= esc($job['location']) ?></div>
                             <div style="font-size: 12px; color: #999;">Job Location</div>
                         </div>
                    </div>
                </div>
                <!-- Job Overview -->
                <div class="sidebar-card">
                    <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 20px;">Job Overview</h3>
                    <div class="overview-grid">
                        <div class="overview-item">
                            <i class="fa-regular fa-calendar" style="color: var(--primary-color);"></i>
                            <div>
                                <span>JOB POSTED:</span>
                                <strong><?= date('d M, Y', strtotime($job['created_at'])) ?></strong>
                            </div>
                        </div>
                        <div class="overview-item">
                            <i class="fa-regular fa-clock" style="color: var(--primary-color);"></i>
                            <div>
                                <span>JOB EXPIRE IN:</span>
                                <strong><?= date('d M, Y', strtotime($job['deadline'])) ?></strong>
                            </div>
                        </div>
                        <div class="overview-item">
                            <i class="fa-solid fa-briefcase" style="color: var(--primary-color);"></i>
                            <div>
                                <span>JOB LEVEL:</span>
                                <strong><?= esc($job['level']) ?></strong>
                            </div>
                        </div>
                        <div class="overview-item">
                            <i class="fa-solid fa-wallet" style="color: var(--primary-color);"></i>
                            <div>
                                <span>EXPERIENCE</span>
                                <strong><?= esc($job['experience']) ?></strong>
                            </div>
                        </div>
                        <div class="overview-item">
                            <i class="fa-solid fa-graduation-cap" style="color: var(--primary-color);"></i>
                            <div>
                                <span>EDUCATION</span>
                                <strong><?= esc($job['education']) ?></strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>