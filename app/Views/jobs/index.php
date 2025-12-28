
    <!-- Page Header -->
    <div class="page-header" style="background:#F2F2F2; padding: 40px 0;">
        <div class="container" style="display: flex; justify-content: space-between; align-items: center;">
            <h2 style="font-size: 24px; font-weight: 600;"><?= lang('App.nav_jobs') ?></h2>
        </div>
    </div>
    <!-- Search Section -->
    <div class="job-list-search-section">
        <div class="container">
            <div class="jobs-filter-box">
                <form action="<?= base_url('jobs') ?>" method="get" style="display: flex; width: 100%; align-items: center; gap: 10px;">
                    <div class="search-input-group">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" name="search" value="<?= esc(service('request')->getGet('search')) ?>" placeholder="<?= lang('App.search_placeholder') ?>">
                    </div>
                    <div class="divider"></div>
                    <div class="search-input-group">
                        <i class="fa-solid fa-location-dot"></i>
                        <input type="text" name="location" value="<?= esc(service('request')->getGet('location')) ?>" placeholder="<?= lang('App.location_placeholder') ?>">
                    </div>
                    <div class="divider"></div>
                    <div class="filter-dropdown-wrapper">
                        <button type="button" class="btn-filter" id="filterBtn">
                            <i class="fa-solid fa-sliders"></i> <?= lang('App.filters') ?>
                        </button>
                        <div class="filter-dropdown-menu" id="filterDropdown">
                            <div class="filter-options-list">
                                <?php 
                                $selectedCats = service('request')->getGet('category') ?? [];
                                foreach($categories as $cat): 
                                ?>
                                <label class="filter-option">
                                    <input type="checkbox" name="category[]" class="auto-submit" value="<?= $cat['id'] ?>" <?= in_array($cat['id'], $selectedCats) ? 'checked' : '' ?>> <?= esc($cat['name']) ?>
                                </label>
                                <?php endforeach; ?>
                            </div>
                            <hr style="margin: 10px 0; border: 0; border-top: 1px solid #EEE;">
                            <button type="submit" id="applyFiltersBtn" class="auth-btn" style="padding: 10px; margin-top: 0; font-size: 13px;"><?= lang('App.apply') ?></button>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary search-btn-job"><?= lang('App.search_btn') ?></button>
                </form>
            </div>
        </div>
    </div>
    <!-- Job Grid -->
    <div class="container" style="padding-bottom: 80px;">
        <div class="grid-3">
            <?php if (!empty($jobs) && is_array($jobs)): ?>
                <?php foreach ($jobs as $job): ?>
                <!-- Job Card -->
                <div class="job-card" onclick="window.location.href='<?= base_url('jobs/details/' . ($job['id'] ?? '#')) ?>'" style="cursor: pointer;">
                     <div class="job-header">
                         <h3 class="job-title"><?= esc($job['title']) ?></h3>
                         <span class="job-type"><?= esc($job['type']) ?></span>
                     </div>
                     <div class="job-company">
                         <?php if(!empty($job['salary_min']) || !empty($job['salary_max'])): ?>
                            Salary: $<?= esc($job['salary_min'] ?? '0') ?> - $<?= esc($job['salary_max'] ?? '0') ?>
                         <?php endif; ?>
                     </div>
                     <div style="margin-top: 20px; display: flex; gap: 10px; align-items: center;">
                         <div style="width: 30px; height: 30px; background: #eee; border-radius: 50%; overflow: hidden; display: flex; align-items: center; justify-content: center; color: #666;">
                            <?php if(!empty($job['logo'])): ?>
                                <img src="<?= base_url('uploads/logos/' . $job['logo']) ?>" alt="Company Logo" style="width: 100%; height: 100%; object-fit: cover;">
                            <?php else: ?>
                                <i class="fa-solid fa-building"></i>
                            <?php endif; ?>
                         </div>
                         <div>
                             <div style="font-weight: 600;"><?= esc($job['company_name']) ?></div>
                             <div style="font-size: 12px; color: #888;"><i class="fa-solid fa-location-dot"></i> <?= esc($job['location']) ?></div>
                         </div>

                     </div>
                 </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12" style="grid-column: 1 / -1; text-align: center; padding: 100px 20px; background: white; border-radius: 12px; border: 1px dashed #DDD;">
                    <div style="font-size: 60px; color: #EEE; margin-bottom: 20px;"><i class="fa-solid fa-magnifying-glass"></i></div>
                    <h3 style="font-size: 24px; font-weight: 700; color: #333; margin-bottom: 10px;"><?= lang('App.no_jobs_found') ?></h3>
                    <p style="color: #666; max-width: 400px; margin: 0 auto;"><?= lang('App.try_adjusting_filters') ?></p>
                </div>
            <?php endif; ?>
        </div>
        <!-- Pagination -->
        <div class="pagination-wrapper">
            <?= $pager->links() ?>
        </div>
    </div>
