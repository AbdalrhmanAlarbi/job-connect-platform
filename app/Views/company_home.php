 
<style>
    /* Card Hover Effects */
    .grid-4 > a > div {
        transition: all 0.3s ease;
        border-radius: 12px;
        border: 1px solid transparent; 
    }
    .grid-4 > a > div:hover {
        transform: translateY(-7px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.08) !important; /* Force override */
        background: #fff;
        border-color: #EBF2FF;
    }

    /* Hero Image Float Animation */
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-15px); }
        100% { transform: translateY(0px); }
    }
    .hero-animate {
        animation: float 5s ease-in-out infinite;
    }
</style>

<section style="padding: 80px 0; background: #fff;">
    <div class="container">
        <div style="display: flex; align-items: center; gap: 50px; flex-wrap: wrap;">
            <!-- Left Content -->
            <div style="flex: 1; min-width: 300px;">
                <h1 style="font-size: 48px; font-weight: 700; line-height: 1.2; margin-bottom: 20px; color: #1A1A1A;">
                    Post Your Job and Find <br> The Right Employee
                </h1>
                <p style="font-size: 16px; color: #666; line-height: 1.6; margin-bottom: 30px;">
                    Aliquam vitae turpis in diam convallis finibus in at risus. Nullam in scelerisque leo, eget sollicitudin velit vestibulum.
                </p>
                <div style="margin-bottom: 40px; font-size: 14px; color: #888;">
                    <strong>Suggestion:</strong> Designer, Programming, <span style="color: var(--primary-color);">Digital Marketing</span>, Video, Animation.
                </div>

                <div style="display: flex; gap: 20px;">
                    <!-- Stat Card 1 -->
                    <div style="background: #EBF2FF; padding: 20px; border-radius: 12px; display: flex; align-items: center; gap: 15px; flex: 1; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
                        <div style="width: 50px; height: 50px; background: #D0E1FD; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--primary-color); font-size: 20px;">
                            <i class="fa-solid fa-briefcase"></i>
                        </div>
                        <div>
                            <h3 style="font-size: 24px; font-weight: 700; margin: 0; color: #1A1A1A;"><?= number_format($total_jobs) ?></h3>
                            <div style="font-size: 13px; color: #666;">Your Job that You post</div>
                        </div>
                    </div>
                    <!-- Stat Card 2 -->
                    <div style="background: #fff; padding: 20px; border-radius: 12px; display: flex; align-items: center; gap: 15px; flex: 1; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #eee;">
                        <div style="width: 50px; height: 50px; background: var(--primary-color); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-size: 20px;">
                            <i class="fa-solid fa-user-group"></i>
                        </div>
                        <div>
                            <h3 style="font-size: 24px; font-weight: 700; margin: 0; color: #1A1A1A;"><?= number_format($total_applications) ?></h3>
                            <div style="font-size: 13px; color: #666;">Applications</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Image -->
            <div style="flex: 1; min-width: 300px; display: flex; justify-content: center;">
                 <div style="position: relative; width: 100%; max-width: 500px;">
                     <!-- Circle Background -->
                     <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 400px; height: 400px; background: #EBF2FF; border-radius: 50%; z-index: 0;"></div>
                     <!-- Illustration -->
                     <img src="<?= base_url('assets/images/company_hero_final.jpg') ?>" alt="Company Illustration" class="hero-animate" style="position: relative; z-index: 1; width: 100%; height: auto; object-fit: contain;">
                 </div>
            </div>
        </div>
    </div>
</section>

<!-- Your Posted Jobs -->
<section style="padding: 60px 0; background: #fff;">
    <div class="container">
        <h2 style="font-size: 32px; font-weight: 700; margin-bottom: 50px; color: #1A1A1A;">Your Jobs</h2>
        
        <div class="grid-3" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px;">
            <?php if(!empty($jobs)): ?>
                <?php foreach($jobs as $job): ?>
                <a href="<?= base_url('company/applications?job_id=' . $job['id']) ?>" style="text-decoration: none; color: inherit; display: block;">
                    <div style="background: #fff; border: 1px solid #E5E7EB; border-radius: 12px; padding: 25px; transition: all 0.2s; position: relative; height: 100%; display: flex; flex-direction: column;">
                         <!-- Status Badge -->
                         <div style="position: absolute; top: 20px; right: 20px;">
                             <span style="background: #ECFDF5; color: #047857; font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 20px; border: 1px solid #D1FAE5;">
                                 <?= strtoupper($job['status']) ?>
                             </span>
                         </div>
                         
                         <h4 style="font-size: 18px; font-weight: 700; color: #111827; margin: 0 0 10px 0; padding-right: 60px;"><?= esc($job['title']) ?></h4>
                         
                         <div style="font-size: 13px; color: #6B7280; margin-bottom: 20px; display: flex; gap: 15px;">
                             <span><i class="fa-regular fa-calendar" style="margin-right: 5px;"></i> <?= date('M d, Y', strtotime($job['created_at'])) ?></span>
                             <span><i class="fa-solid fa-briefcase" style="margin-right: 5px;"></i> <?= esc($job['type']) ?></span>
                         </div>
                         
                         <div style="margin-top: auto; border-top: 1px solid #F3F4F6; padding-top: 15px; display: flex; align-items: center; justify-content: space-between;">
                             <div style="display: flex; align-items: center; gap: 8px; color: var(--primary-color);">
                                 <i class="fa-solid fa-users" style="font-size: 14px;"></i>
                                 <span style="font-weight: 700; font-size: 15px;"><?= $job['application_count'] ?></span>
                                 <span style="font-size: 13px; color: #6B7280; font-weight: 500;">Applicants</span>
                             </div>
                             
                             <span style="font-size: 13px; font-weight: 600; color: var(--primary-color);">View <i class="fa-solid fa-arrow-right" style="font-size: 11px; margin-left: 3px;"></i></span>
                         </div>
                    </div>
                </a>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="grid-column: 1 / -1; text-align: center; padding: 60px; background: #F9FAFB; border-radius: 16px; border: 1px dashed #D1D5DB;">
                    <div style="width: 60px; height: 60px; background: #EFF6FF; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; color: var(--primary-color); font-size: 24px;">
                        <i class="fa-solid fa-folder-open"></i>
                    </div>
                    <h3 style="font-size: 18px; font-weight: 700; color: #111827; margin-bottom: 10px;">No Jobs Posted Yet</h3>
                    <p style="color: #6B7280; margin-bottom: 25px;">Create your first job posting to start finding candidates.</p>
                    <a href="<?= base_url('company/post-job') ?>" class="btn btn-primary">Post Your First Job</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
        </div>
    </div>
</section>
<!-- Spotlight & Grid Background Effect -->
<div class="spotlight-bg"></div>

<style>
    /* Force body to be transparent so fixed background shows */
    body {
        margin: 0;
        min-height: 100vh;
        background-color: transparent !important;
    }

    .spotlight-bg {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        pointer-events: none;
        z-index: -100; /* Deep background */
        background-color: #ffffff;
        
        /* Grid Pattern - Extremely Light/Subtle */
        background-image: 
            linear-gradient(rgba(0,0,0,0.03) 1px, transparent 1px),
            linear-gradient(90deg, rgba(0,0,0,0.03) 1px, transparent 1px);
        background-size: 40px 40px;
    }

    /* The Moving Blue Glow */
    .spotlight-bg::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(
            600px circle at var(--mouse-x, 50%) var(--mouse-y, 50%), 
            rgba(0, 102, 255, 0.06), 
            transparent 40%
        );
        z-index: -1;
    }

    /* Make Sections Transparent to reveal grid */
    section {
        background: transparent !important;
        position: relative;
        z-index: 2;
    }

    /* Explicitly Restore Hero Element Colors */
    .hero-stat-blue {
        background-color: #EBF2FF !important;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03) !important;
    }
    .hero-stat-white {
        background-color: #fff !important;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05) !important;
    }
    .hero-circle {
        background-color: #EBF2FF !important;
    }

    /* Keep Category Cards White */
    .grid-4 > a > div {
        background-color: #fff !important;
        box-shadow: 0 4px 20px rgba(0,0,0,0.04);
    }
    
    /* Special handling for the header */
    nav, header {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(5px);
    }
</style>

<script>
    document.addEventListener('mousemove', (e) => {
        document.documentElement.style.setProperty('--mouse-x', e.clientX + 'px');
        document.documentElement.style.setProperty('--mouse-y', e.clientY + 'px');
    });
</script>
```
