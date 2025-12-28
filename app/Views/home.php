
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-glow"></div>
        <div class="hero-grid"></div>
        <div class="container">
            <div class="hero">
                <div class="hero-content">
                    <h1 class="hero-title"><?= lang('App.hero_title') ?></h1>
                    <p class="hero-subtitle"><?= lang('App.hero_subtitle') ?></p>
                    
                    <form action="<?= base_url('jobs') ?>" method="get" class="search-wrapper">
                        <div class="search-box">
                            <i class="fa-solid fa-magnifying-glass" style="padding: 15px; color: #999;"></i>
                            <input type="text" name="search" class="search-input" placeholder="Job title, or company">
                            <div style="border-left: 1px solid #eee; margin: 5px 0;"></div>
                            <i class="fa-solid fa-location-dot" style="padding: 15px; color: #999;"></i>
                            <input type="text" name="location" class="search-input" placeholder="City or region">
                        </div>
                        <button type="submit" class="btn btn-primary search-btn-home"><?= lang('App.search_btn') ?></button>
                    </form>
                    <div class="stats">
                        <div class="stat-card">
                            <div class="stat-icon"><i class="fa-solid fa-briefcase"></i></div>
                            <div>
                                <h3 style="font-size: 18px; font-weight:700;"><?= number_format($total_jobs) ?></h3>
                                <div style="font-size: 13px; color: #666;"><?= lang('App.live_jobs') ?></div>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon"><i class="fa-solid fa-building"></i></div>
                            <div>
                                <h3 style="font-size: 18px; font-weight:700;"><?= number_format($total_companies) ?></h3>
                                <div style="font-size: 13px; color: #666;"><?= lang('App.companies') ?></div>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon"><i class="fa-solid fa-users"></i></div>
                            <div>
                                <h3 style="font-size: 18px; font-weight:700;"><?= number_format($total_candidates) ?></h3>
                                <div style="font-size: 13px; color: #666;"><?= lang('App.candidates') ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hero-image">
                    <img src="<?= base_url('assets/images/uploaded_image_1765370079732.png') ?>" alt="Hero Image">
                </div>
            </div>
        </div>
    </section>
    <!-- Popular Vacancies -->
<section>
  <div class="container">
    <h2 class="section-title"><?= lang('App.popular_vacancies') ?></h2>

    <div class="grid-4 vacancies-grid" style="margin-bottom: 40px;">
      <?php foreach ($popular_vacancies as $vacancy): ?>
        <a href="<?= base_url('jobs?search=' . urlencode($vacancy['title'])) ?>" style="display: block; text-decoration: none; color: inherit;">
            <div>
            <strong><?php echo htmlspecialchars($vacancy['title'], ENT_QUOTES, 'UTF-8'); ?></strong>
            <small><?php echo number_format((int)$vacancy['count']); ?> <?= lang('App.open_positions') ?></small>
            </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

    <!-- How it works -->
    <section style="background: #F0F2F5;">
        <div class="container" style="text-align: center;">
            <h2 class="section-title" style="text-align: center;"><?= lang('App.how_it_works') ?></h2>
            
            <div class="grid-4" style="text-align: center; margin-top: 40px;">
                <!-- Step 1 -->
                <div>
                     <div style="width: 70px; height: 70px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 24px; color: var(--primary-color); box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
                        <i class="fa-solid fa-user-plus"></i>
                     </div>
                     <h4><?= lang('App.step_1') ?></h4>
                </div>
                <!-- Step 2 -->
                <div>
                     <div style="width: 70px; height: 70px; background: var(--primary-color); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 24px; color: white; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                     </div>
                     <h4><?= lang('App.step_2') ?></h4>
                </div>
                <!-- Step 3 -->
                <div>
                     <div style="width: 70px; height: 70px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 24px; color: var(--primary-color); box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
                        <i class="fa-solid fa-magnifying-glass"></i>
                     </div>
                     <h4><?= lang('App.step_3') ?></h4>
                </div>
                <!-- Step 4 -->
                 <div>
                     <div style="width: 70px; height: 70px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 24px; color: var(--primary-color); box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
                        <i class="fa-solid fa-check"></i>
                     </div>
                     <h4><?= lang('App.step_4') ?></h4>
                </div>
            </div>
        </div>
    </section>
    <!-- Popular Category -->
    <section>
        <div class="container">
             <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px;">
                <h2 class="section-title" style="margin-bottom:0;"><?= lang('App.popular_category') ?></h2>
             </div>
             
             <div class="grid-4 vacancies-grid">
                 <?php foreach($cats as $cat): ?>
                  <a href="<?= base_url('jobs?category[]=' . $cat['id']) ?>" style="display: flex; align-items: center; gap: 15px; padding: 20px; background: #F8F9FA; border-radius: 8px; cursor: pointer; transition: 0.3s; text-decoration: none; color: inherit;" onmouseover="this.style.background='white'; this.style.boxShadow='0 5px 15px rgba(0,0,0,0.05)'" onmouseout="this.style.background='#F8F9FA'; this.style.boxShadow='none'">
                      <div style="width: 50px; height: 50px; background: white; display: flex; align-items: center; justify-content: center; color: var(--primary-color); border-radius: 8px;">
                          <i class="fa-solid <?= $cat['icon'] ?>" style="font-size: 20px;"></i>
                      </div>
                      <div>
                          <div style="font-weight: 700; font-size: 16px;"><?= esc($cat['name']) ?></div>
                          <div style="font-size: 13px; color: #666;"><?= $cat['job_count'] ?> Open Positions</div>
                      </div>
                  </a>
                 <?php endforeach; ?>
             </div>
        </div>
    </section>
    <!-- Featured Jobs -->
    <section style="background: white;">
        <div class="container">
             <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px;">
                <h2 class="section-title" style="margin-bottom:0;"><?= lang('App.featured_job') ?></h2>
                <a href="<?= base_url('jobs') ?>" class="btn btn-outline"><?= lang('App.view_all') ?> <i class="fa-solid fa-arrow-right"></i></a>
             </div>
             <div class="grid-3">
                 <?php if(!empty($recent_jobs)): ?>
                 <?php foreach($recent_jobs as $job): ?>
                 <!-- Job Card -->
                 <div class="job-card" onclick="window.location.href='<?= base_url('jobs/details/'.$job['id']) ?>'" style="cursor: pointer;">
                     <div class="job-header">
                         <h3 class="job-title"><?= esc($job['title']) ?></h3>
                         <span class="job-type"><?= esc($job['type']) ?></span>
                     </div>
                     <div class="job-company">
                         <?php if($job['salary_min']): ?>
                         Salary: $<?= number_format($job['salary_min']) ?> - $<?= number_format($job['salary_max']) ?>
                         <?php endif; ?>
                     </div>
                     <div style="margin-top: 20px; display: flex; gap: 10px; align-items: center;">
                         <div style="width: 30px; height: 30px; background: #eee; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #666;">
                             <i class="fa-solid fa-building"></i>
                         </div>
                         <div>
                             <div style="font-weight: 600;"><?= esc($job['company_name']) ?></div>
                             <div style="font-size: 12px; color: #888;"><i class="fa-solid fa-location-dot"></i> <?= esc($job['location']) ?></div>
                         </div>

                     </div>
                 </div>
                 <?php endforeach; ?>
                 <?php endif; ?>
             </div>
        </div>
    </section>
    <!-- Top Companies -->
    <section>
        <div class="container">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px;">
                <h2 class="section-title" style="margin-bottom:0;"><?= lang('App.top_companies') ?></h2>
                
             </div>
            <div class="grid-3">
                <?php foreach($companies as $co): ?>
                <!-- Company Card -->
                <div class="company-card-new" onclick="window.location.href='<?= base_url('jobs?search=' . urlencode($co['name'])) ?>'" style="cursor: pointer; display: flex; flex-direction: column;">
                    <div style="display: flex; gap: 15px; margin-bottom: 20px; flex: 1;">
                        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #FF4F81 0%, #FF6B9D 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px; flex-shrink: 0;">
                            <i class="fa-solid fa-building"></i>
                        </div>
                        <div style="flex: 1; min-width: 0;">
                            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                                <h3 style="font-size: 16px; font-weight: 700; margin: 0; color: #1A1A1A;"><?= esc($co['name']) ?></h3>
                            </div>
                            <div style="font-size: 13px; color: #666; display: flex; align-items: center; gap: 4px;">
                                <i class="fa-solid fa-location-dot" style="font-size: 12px;"></i>
                                <?= esc($co['location']) ?>
                            </div>
                        </div>
                    </div>
                    <button style="width: 100%; background: #E8F1FF; color: var(--primary-color); border: none; padding: 12px; border-radius: 6px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.3s; margin-top: auto;" onmouseover="this.style.background='var(--primary-color)'; this.style.color='white';" onmouseout="this.style.background='#E8F1FF'; this.style.color='var(--primary-color)';">
                        <?= lang('App.open_positions') ?> (<?= $co['job_count'] ?>)
                    </button>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>


<?php if (session()->getFlashdata('pending_signup')): ?>
<div id="pendingOverlay" style="position: fixed; inset: 0; background: rgba(0, 0, 0, 0.85); z-index: 9999; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(5px);">
    <div style="background: white; width: 420px; border-radius: 20px; padding: 40px; text-align: center; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); animation: simpleScale 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);">
        <style>
            @keyframes simpleScale {
                from { opacity: 0; transform: scale(0.95); }
                to { opacity: 1; transform: scale(1); }
            }
            .loading-dots { display: flex; justify-content: center; gap: 8px; margin: 25px 0; }
            .dot { width: 10px; height: 10px; background: var(--primary-color); border-radius: 50%; animation: bounce 1.4s infinite ease-in-out both; }
            .dot:nth-child(1) { animation-delay: -0.32s; }
            .dot:nth-child(2) { animation-delay: -0.16s; }
            @keyframes bounce {
                0%, 80%, 100% { transform: scale(0); }
                40% { transform: scale(1); }
            }
        </style>
        
        <div style="width: 70px; height: 70px; background: #EBF2FF; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; color: var(--primary-color);">
            <i class="fa-regular fa-clock" style="font-size: 32px;"></i>
        </div>
        
        <h2 style="font-size: 24px; font-weight: 800; color: #111827; margin-bottom: 12px;">Request Waiting...</h2>
        <p style="color: #6B7280; font-size: 15px; line-height: 1.6; margin-bottom: 10px;">
            Your company account request is currently under review by our admin team.
        </p>
        
        <div class="loading-dots">
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
        </div>
        
        <button onclick="document.getElementById('pendingOverlay').style.display='none'" 
                style="background: var(--primary-color); color: white; border: none; padding: 12px 30px; border-radius: 10px; font-weight: 600; font-size: 14px; cursor: pointer; transition: background 0.2s; width: 100%; margin-top: 10px;"
                onmouseover="this.style.background='var(--primary-dark)'" 
                onmouseout="this.style.background='var(--primary-color)'">
            OK
        </button>
    </div>
</div>
<?php endif; ?>
