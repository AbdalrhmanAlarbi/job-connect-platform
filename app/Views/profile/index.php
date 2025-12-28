
<div style="background-color: #f3f4f6; min-height: 100vh; padding: 40px 0;">
    <div class="container">
        
        <?php if(session()->getFlashdata('success')): ?>
            <div style="background: #D1FAE5; color: #065F46; padding: 15px; border-radius: 8px; margin-bottom: 30px; border: 1px solid #A7F3D0; display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>



        <div style="display: grid; grid-template-columns: 280px 1fr; gap: 30px; align-items: start;">
            
            <!-- LEFT SIDEBAR: PROFILE CARD -->
            <div style="background: white; border-radius: 16px; padding: 30px 20px; text-align: center; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
                <div style="position: relative; width: 120px; height: 120px; margin: 0 auto 20px;">
                    <?php if(!empty($profile['logo'])): ?>
                        <img src="<?= base_url('uploads/logos/' . $profile['logo']) ?>" alt="Logo" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover; border: 4px solid #F3F4F6;">
                    <?php else: ?>
                        <div style="width: 100%; height: 100%; border-radius: 50%; background: var(--primary-color); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 48px; border: 4px solid #F3F4F6;">
                            <?= substr(esc($user['name']), 0, 1) ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <h2 style="font-size: 20px; font-weight: 700; color: #111827; margin-bottom: 5px;"><?= esc($user['name']) ?></h2>
                <div style="color: #6B7280; font-size: 14px; margin-bottom: 20px;"><?= esc($user['email']) ?></div>
                
                <span style="background: #EFF6FF; color: var(--primary-color); padding: 6px 16px; border-radius: 20px; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">
                    <?= esc($user['role']) ?>
                </span>

                <div style="margin-top: 30px; padding-top: 25px; border-top: 1px solid #F3F4F6; text-align: left;">
                    <div style="margin-bottom: 15px; font-size: 13px; color: #6B7280; display: flex; align-items: center; gap: 10px;">
                        <i class="fa-solid fa-location-dot" style="width: 20px; text-align: center;"></i> <?= esc($profile['location'] ?? 'N/A') ?>
                    </div>
                    <?php if(isset($profile['phone'])): ?>
                    <div style="margin-bottom: 15px; font-size: 13px; color: #6B7280; display: flex; align-items: center; gap: 10px;">
                        <i class="fa-solid fa-phone" style="width: 20px; text-align: center;"></i> <?= esc($profile['phone']) ?>
                    </div>
                    <?php endif; ?>
                    <div style="font-size: 13px; color: #6B7280; display: flex; align-items: center; gap: 10px;">
                        <i class="fa-solid fa-calendar" style="width: 20px; text-align: center;"></i> Joined <?= date('M Y', strtotime($user['created_at'])) ?>
                    </div>
                </div>
            </div>

            <!-- RIGHT CONTENT: EDIT FORMS -->
            <div style="display: flex; flex-direction: column; gap: 30px;">
                
                <!-- 1. PERSONAL INFORMATION FORM -->
                <div style="background: white; border-radius: 16px; padding: 30px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; padding-bottom: 15px; border-bottom: 1px solid #F3F4F6;">
                        <h3 style="font-size: 18px; font-weight: 700; color: #111827; margin: 0;">Profile Information</h3>
                    </div>

                    <?php if($isOwner): ?>
                    <form action="<?= base_url('profile/update') ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 25px; margin-bottom: 25px;">
                            <div>
                                <label style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px;">Full Name</label>
                                <input type="text" name="name" value="<?= esc($user['name']) ?>" class="form-control" style="width: 100%; padding: 12px 16px; border: 1px solid #D1D5DB; border-radius: 8px; font-size: 14px; transition: border-color 0.2s; outline: none;">
                            </div>
                            <div>
                                <label style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px;">Email Address</label>
                                <input type="email" value="<?= esc($user['email']) ?>" class="form-control" style="width: 100%; padding: 12px 16px; border: 1px solid #D1D5DB; border-radius: 8px; font-size: 14px; outline: none; background: #f9fafb;" readonly>
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 25px; margin-bottom: 25px;">
                            <?php if($user['role'] === 'candidate'): ?>
                            <div>
                                <label style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px;">Phone Number</label>
                                <input type="text" name="phone" value="<?= esc($profile['phone'] ?? '') ?>" class="form-control" style="width: 100%; padding: 12px 16px; border: 1px solid #D1D5DB; border-radius: 8px; font-size: 14px; outline: none;">
                            </div>
                            <?php endif; ?>
                            <div>
                                <label style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px;">Location / City</label>
                                <input type="text" name="location" value="<?= esc($profile['location'] ?? '') ?>" class="form-control" style="width: 100%; padding: 12px 16px; border: 1px solid #D1D5DB; border-radius: 8px; font-size: 14px; outline: none;">
                            </div>
                        </div>

                        <?php if($user['role'] === 'company'): ?>
                        <div style="margin-bottom: 25px;">
                            <label style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px;">Website URL</label>
                            <input type="url" name="website" value="<?= esc($profile['website'] ?? '') ?>" class="form-control" placeholder="https://example.com" style="width: 100%; padding: 12px 16px; border: 1px solid #D1D5DB; border-radius: 8px; font-size: 14px; outline: none;">
                        </div>
                        <div style="margin-bottom: 25px;">
                            <label style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px;">Company Logo</label>
                            <input type="file" name="logo" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #D1D5DB; border-radius: 8px; font-size: 14px; outline: none;">
                            <?php if(!empty($profile['logo'])): ?>
                                <div style="margin-top: 5px; font-size: 12px; color: #059669; display: flex; align-items: center; gap: 5px;">
                                    <i class="fa-solid fa-image"></i> Current Logo: <strong><?= esc($profile['logo']) ?></strong> (Upload new to replace)
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>

                        <div style="margin-bottom: 25px;">
                            <label style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px;"><?= $user['role'] === 'company' ? 'Company Description' : 'About Me (Bio)' ?></label>
                            <textarea name="<?= $user['role'] === 'company' ? 'description' : 'bio' ?>" rows="4" class="form-control" style="width: 100%; padding: 12px 16px; border: 1px solid #D1D5DB; border-radius: 8px; font-size: 14px; font-family: inherit; outline: none; resize: vertical;"><?= esc($profile['bio'] ?? $profile['description'] ?? '') ?></textarea>
                        </div>
                        
                        <!-- UPLOAD CV SECTION (Candidate Only) -->
                        <?php if($user['role'] === 'candidate'): ?>
                        
                         <div style="margin-bottom: 25px;">
                            <label style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px;">Profile Picture</label>
                            <input type="file" name="logo" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #D1D5DB; border-radius: 8px; font-size: 14px; outline: none;">
                            <?php if(!empty($profile['logo'])): ?>
                                <div style="margin-top: 5px; font-size: 12px; color: #059669; display: flex; align-items: center; gap: 5px;">
                                    <i class="fa-solid fa-image"></i> Current Picture: <strong><?= esc($profile['logo']) ?></strong> (Upload new to replace)
                                </div>
                            <?php endif; ?>
                        </div>

                         <div style="margin-bottom: 30px;">
                            <label style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px;">Upload CV / Resume</label>
                            <div style="border: 2px dashed #D1D5DB; border-radius: 8px; padding: 20px; text-align: center; background: #F9FAFB; cursor: pointer; transition: background 0.2s;" onclick="document.getElementById('cv_upload').click()">
                                <i class="fa-solid fa-cloud-arrow-up" style="font-size: 24px; color: #9CA3AF; margin-bottom: 10px;"></i>
                                <div style="font-size: 14px; color: #4B5563; font-weight: 500;">Click to upload or drag and drop</div>
                                <div style="font-size: 12px; color: #9CA3AF;">PDF, DOCX up to 5MB</div>
                                <input type="file" name="cv_file" id="cv_upload" style="display: none;">
                            </div>
                            <?php if(!empty($profile['resume_path'])): ?>
                                <?php if(file_exists(FCPATH . $profile['resume_path'])): ?>
                                    <div style="margin-top: 10px; font-size: 13px; color: #059669; display: flex; align-items: center; gap: 5px;">
                                        <i class="fa-solid fa-file-check"></i> Current CV: <a href="<?= base_url($profile['resume_path']) ?>" target="_blank" style="color: inherit; font-weight: 700;">View Resume</a>
                                    </div>
                                <?php else: ?>
                                    <div style="margin-top: 10px; font-size: 13px; color: #DC2626; display: flex; align-items: center; gap: 5px; background: #FEF2F2; padding: 8px; border-radius: 6px; border: 1px solid #FECACA;">
                                        <i class="fa-solid fa-circle-exclamation"></i> <strong>File Missing:</strong> Your CV cannot be found. Please upload a new one to apply for jobs.
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>


                        <div style="text-align: right;">
                            <button type="submit" style="background: var(--primary-color); color: white; padding: 12px 24px; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: opacity 0.2s;">
                                Save Changes
                            </button>
                        </div>
                    </form>
                    <?php else: ?>
                    <!-- READ ONLY MODE -->
                     <div style="color: #4B5563; line-height: 1.6;">
                        <?= nl2br(esc($profile['bio'] ?? $profile['description'] ?? 'No bio available.')) ?>
                    </div>
                    <?php if($user['role'] === 'company' && !empty($profile['website'])): ?>
                        <div style="margin-top: 20px;">
                             <a href="<?= esc($profile['website']) ?>" target="_blank" style="color: var(--primary-color); text-decoration: none; display: flex; align-items: center; gap: 8px; font-weight: 500;">
                                <i class="fa-solid fa-globe"></i> <?= esc($profile['website']) ?>
                            </a>
                        </div>
                    <?php endif; ?>

                     <?php if($user['role'] === 'candidate' && !empty($profile['resume_path'])): ?>
                        <div style="margin-top: 30px;">
                            <a href="<?= base_url($profile['resume_path']) ?>" target="_blank" style="background: var(--primary-color); color: white; padding: 12px 24px; text-decoration: none; border-radius: 8px; font-weight: 600; display: inline-flex; align-items: center; gap: 10px;">
                                <i class="fa-solid fa-download"></i> Download CV
                            </a>
                        </div>
                    <?php endif; ?>
                    <?php endif; ?>
                </div>

                <?php if($isOwner): ?>
                <!-- 2. CHANGE PASSWORD FORM -->
                <div style="background: white; border-radius: 16px; padding: 30px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; padding-bottom: 15px; border-bottom: 1px solid #F3F4F6;">
                        <h3 style="font-size: 18px; font-weight: 700; color: #111827; margin: 0;">Security Settings</h3>
                    </div>

                    <?php if(session()->getFlashdata('error')): ?>
                        <div style="background: #FEF2F2; color: #991B1B; padding: 10px 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #FECaca; display: flex; align-items: center; gap: 10px; font-size: 13px;">
                            <i class="fa-solid fa-circle-exclamation"></i> <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>
                    
                    <form action="<?= base_url('profile/change-password') ?>" method="post">
                        <?= csrf_field() ?>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 25px;">
                            <div>
                                <label style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px;">New Password</label>
                                <div class="password-wrapper">
                                    <input type="password" name="new_password" class="form-control" style="width: 100%; padding: 12px 16px; border: 1px solid #D1D5DB; border-radius: 8px; outline: none;">
                                    <i class="fa-solid fa-eye password-toggle" onclick="togglePasswordVisibility(this)"></i>
                                </div>
                            </div>
                            <div>
                                <label style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px;">Confirm New Password</label>
                                <div class="password-wrapper">
                                    <input type="password" name="confirm_password" class="form-control" style="width: 100%; padding: 12px 16px; border: 1px solid #D1D5DB; border-radius: 8px; outline: none;">
                                    <i class="fa-solid fa-eye password-toggle" onclick="togglePasswordVisibility(this)"></i>
                                </div>
                            </div>
                        </div>
                        <div style="text-align: right; margin-top: 25px;">
                            <button type="submit" style="background: white; color: #DC2626; border: 1px solid #FCA5A5; padding: 10px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: background 0.2s;">
                                Update Password
                            </button>
                        </div>
                    </form>
                </div>
                <?php endif; ?>

            </div>

        </div>
    </div>
</div>
