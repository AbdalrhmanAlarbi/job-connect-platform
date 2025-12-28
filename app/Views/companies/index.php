
    <style>
        .companies-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
        }
        
        @media (max-width: 992px) {
            .companies-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 600px) {
            .companies-grid {
                grid-template-columns: 1fr;
            }
        }

        .company-card-new {
            background: white;
            border: 1px solid #E5E7EB;
            border-radius: 12px;
            padding: 24px;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 200px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .company-card-new:hover {
            border-color: var(--primary-color);
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }

        /* Top Section */
        .card-top {
            position: relative;
            z-index: 2;
        }

        .company-name-title {
            font-size: 16px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 20px;
        }

        .badges-row {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 11px;
            flex-wrap: wrap;
        }

        .card-middle {
            display: flex;
            align-items: center;
            flex: 1;
        }

        .badge-green {
            background: #D1FAE5;
            color: #059669;
            padding: 4px 10px;
            border-radius: 4px;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .time-badge {
            color: #6B7280;
            font-weight: 500;
        }

        /* Bottom Section */
        .card-bottom {
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .logo-row {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .small-logo {
            width: 24px;
            height: 24px;
            object-fit: contain;
        }

        .brand-name {
            font-weight: 600;
            font-size: 15px;
            color: #374151;
        }

        .location-text {
            color: #6B7280;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Watermark */
        .watermark-logo {
            position: absolute;
            top: 50%;
            right: -20px;
            transform: translateY(-50%);
            height: 140%;
            width: auto;
            opacity: 0.04;
            z-index: 1;
            pointer-events: none;
            filter: grayscale(100%);
        }
        
        /* Remove Bookmark as requested */
    </style>
    <!-- Page Header -->
    <div class="page-header" style="background:#F2F2F2; padding: 40px 0;">
        <div class="container" style="display: flex; justify-content: space-between; align-items: center;">
            <h2 style="font-size: 24px; font-weight: 600;"><?= lang('App.nav_companies') ?></h2>
        </div>
    </div>
    
    <!-- Search / Filter (Simplified for Companies) -->
    <div class="container" style="margin-top: 30px; margin-bottom: 30px;">
        <div class="jobs-filter-box" style="padding: 20px;">
             <form action="<?= base_url('companies') ?>" method="get" style="display: flex; width: 100%; gap: 15px; align-items: center;">
                 <i class="fa-solid fa-magnifying-glass search-icon"></i>
                 <input type="text" name="search" value="<?= esc(service('request')->getGet('search')) ?>" placeholder="<?= lang('App.search_company_placeholder') ?>" style="border: none; outline: none; flex: 1; font-size: 16px;">
                 <div class="divider"></div>
                 <i class="fa-solid fa-location-dot location-icon"></i>
                 <input type="text" name="location" value="<?= esc(service('request')->getGet('location')) ?>" placeholder="<?= lang('App.location_placeholder') ?>" style="border: none; outline: none; flex: 1; font-size: 16px;">
                 <button type="submit" class="btn btn-primary" style="padding: 10px 30px;"><?= lang('App.find_company_btn') ?></button>
             </form>
        </div>
    </div>
    <!-- Company Grid -->
    <div class="container" style="padding-bottom: 80px;">
        <div class="companies-grid">
            
            <?php foreach($companies as $company): ?>
            <div class="company-card-new" onclick="window.location.href='<?= base_url('companies/details/' . $company['id']) ?>'">
                <div class="card-top"> 
                     <div class="logo-row">
                        <!-- Small Logo -->
                        <?php if($company['logo']): ?>
                            <img src="<?= (strpos($company['logo'], 'http') === 0) ? $company['logo'] : base_url('uploads/logos/' . $company['logo']) ?>" alt="Logo" class="small-logo">
                        <?php else: ?>
                            <div class="small-logo" style="background: var(--primary-color); color: white; border-radius: 4px; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 12px;"><?= substr(esc($company['name']), 0, 1) ?></div>
                        <?php endif; ?>
                        <div class="company-name-title" style="margin-bottom: 0; font-size: 15px;"><?= esc($company['name']) ?></div>
                    </div>
                </div>

                <div class="card-middle">
                    <div class="badges-row">
                        <span class="badge-green"><?= lang('App.hiring') ?></span>
                        <span class="time-text" style="font-weight: 500; color: #666;"><?= lang('App.active_jobs') ?> <?= $company['job_count'] ?></span>
                    </div>
                </div>

                <div class="card-bottom">
                    <div class="location-text">
                        <i class="fa-solid fa-location-dot"></i> <?= esc($company['location']) ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            
            <?php if(empty($companies)): ?>
                <div style="grid-column: 1 / -1; text-align: center; padding: 100px 20px; background: white; border-radius: 12px; border: 1px dashed #DDD;">
                    <div style="font-size: 60px; color: #EEE; margin-bottom: 20px;"><i class="fa-solid fa-building"></i></div>
                    <h3 style="font-size: 24px; font-weight: 700; color: #333; margin-bottom: 10px;"><?= lang('App.no_companies_found') ?></h3>
                    <p style="color: #666; max-width: 400px; margin: 0 auto;"><?= lang('App.try_adjusting_filters') ?></p>
                </div>
            <?php endif; ?>
        </div>
        
         <!-- Pagination -->
        <div class="pagination-wrapper" style="direction: ltr;">
            <?= $pager->links() ?>
        </div>
    </div>
