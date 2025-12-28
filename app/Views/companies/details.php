
    <!-- Page Header -->
    <div class="page-header" style="background:#F2F2F2; padding: 40px 0;">
        <div class="container" style="display: flex; justify-content: space-between; align-items: center;">
            <h2 style="font-size: 24px; font-weight: 600;"><?= esc($company['name']) ?></h2>
        </div>
    </div>

    <div class="container" style="padding: 50px 0;">
        <div class="job-details-grid"> <!-- Reusing job details grid layout -->
            
            <!-- Left Column: Info & Jobs -->
            <div class="job-info-col">
                <div class="job-header-box">
                    <div style="width: 80px; height: 80px; background: #eee; border-radius: 50%; display:flex; align-items:center; justify-content:center; font-weight:bold; font-size:24px; color:#555; overflow:hidden;">
                        <?php if(!empty($company['logo'])): ?>
                            <img src="<?= base_url('uploads/logos/' . $company['logo']) ?>" style="width:100%; height:100%; object-fit:cover;">
                        <?php else: ?>
                            <i class="fa-solid fa-building"></i>
                        <?php endif; ?>
                    </div>
                    <div style="flex: 1;">
                        <h1 style="font-size: 24px; font-weight: 700; margin-bottom: 5px;"><?= esc($company['name']) ?></h1>
                       
                    </div>
                </div>

                <div class="content-block">
                    <h3><?= lang('App.about_company') ?></h3>
                    <div style="line-height: 1.6; color: #555;">
                        <?= nl2br(esc($company['description'])) ?>
                    </div>
                </div>

                <!-- Open Positions -->
                <div class="content-block">
                    <h3><?= lang('App.open_positions') ?> (<?= count($jobs) ?>)</h3>
                    <?php if(!empty($jobs)): ?>
                    <div class="grid-1" style="gap: 20px;">
                        <?php foreach($jobs as $job): ?>
                        <div class="job-card" onclick="window.location.href='<?= base_url('jobs/details/'.$job['id']) ?>'" style="cursor: pointer; padding: 20px; border: 1px solid #eee;">
                            <div class="job-header">
                                <h4 style="font-size: 18px; margin:0;"><?= esc($job['title']) ?></h4>
                                <span class="job-type"><?= esc($job['type']) ?></span>
                            </div>
                            <div style="display: flex; justify-content: space-between; margin-top: 10px; font-size: 13px; color: #666;">
                                <span><i class="fa-solid fa-location-dot"></i> <?= esc($job['location']) ?></span>
                                <span><i class="fa-regular fa-clock"></i> <?= date('d M, Y', strtotime($job['created_at'])) ?></span>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php else: ?>
                        <p><?= lang('App.no_jobs_found') ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Right Column: Sidebar -->
            <div class="job-sidebar-col">
                <div class="sidebar-card">
                    <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 20px;"><?= lang('App.contact_info') ?></h3>
                    <div class="overview-item">
                        <i class="fa-solid fa-location-dot" style="color: var(--primary-color);"></i>
                        <div>
                            <span><?= lang('App.location_label') ?></span>
                            <strong><?= esc($company['location']) ?></strong>
                        </div>
                    </div>
                    <?php if(!empty($company['website'])): ?>
                    <div class="overview-item">
                        <i class="fa-solid fa-globe" style="color: var(--primary-color);"></i>
                        <div>
                            <span><?= lang('App.website_label') ?></span>
                            <strong><a href="<?= esc($company['website']) ?>" target="_blank" style="color: #333; text-decoration: none;"><?= lang('App.view_website') ?></a></strong>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
