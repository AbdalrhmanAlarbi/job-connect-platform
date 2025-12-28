
<div style="background-color: #F8F9FA; min-height: 100vh; padding: 40px 0;">
    <div class="container">
        <!-- Page Title -->
        <h2 style="font-size: 24px; font-weight: 700; color: #1A1A1A; margin-bottom: 30px;">Post a New Job</h2>

        <!-- Form Card -->
        <div style="background: #fff; border-radius: 16px; box-shadow: 0 5px 20px rgba(0,0,0,0.03); padding: 50px; max-width: 800px; margin: 0 auto;">
            
            <?php if(session()->getFlashdata('error')): ?>
                <div style="background: #FEE2E2; color: #991B1B; padding: 15px; border-radius: 8px; margin-bottom: 30px; border: 1px solid #FECACA; font-weight: 500; font-size: 14px;">
                    <i class="fa-solid fa-circle-exclamation" style="margin-right: 8px;"></i><?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('company/save-job') ?>" method="post">
                
                <div class="form-group" style="margin-bottom: 25px;">
                    <label style="display: block; font-weight: 500; font-size: 14px; color: #666; margin-bottom: 10px;">Job Title</label>
                    <input type="text" name="title" class="form-control" value="<?= old('title') ?>" placeholder="e.g. Senior Laravel Developer" style="width: 100%; padding: 12px 15px; border: 1px solid #eee; border-radius: 6px; font-size: 15px; background: #fff;">
                </div>

                <div class="form-group" style="margin-bottom: 25px;">
                    <label style="display: block; font-weight: 500; font-size: 14px; color: #666; margin-bottom: 10px;">Job Type</label>
                    <select name="type" class="form-control" style="width: 100%; padding: 12px 15px; border: 1px solid #eee; border-radius: 6px; font-size: 15px; background: #fff; appearance: none; -webkit-appearance: none; background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23333%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 15px top 50%; background-size: 10px auto;">
                        <option value="">Select Type...</option>
                        <option value="Full Time" <?= old('type') === 'Full Time' ? 'selected' : '' ?>>Full Time</option>
                        <option value="Part Time" <?= old('type') === 'Part Time' ? 'selected' : '' ?>>Part Time</option>
                        <option value="Freelance" <?= old('type') === 'Freelance' ? 'selected' : '' ?>>Freelance</option>
                        <option value="Contract" <?= old('type') === 'Contract' ? 'selected' : '' ?>>Contract</option>
                    </select>
                </div>

                <div class="form-group" style="margin-bottom: 25px;">
                    <label style="display: block; font-weight: 500; font-size: 14px; color: #666; margin-bottom: 10px;">Category</label>
                     <select name="category_id" class="form-control" style="width: 100%; padding: 12px 15px; border: 1px solid #eee; border-radius: 6px; font-size: 15px; background: #fff; appearance: none; -webkit-appearance: none; background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23333%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 15px top 50%; background-size: 10px auto;">
                        <option value="">Select Category...</option>
                        <?php foreach($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= old('category_id') == $cat['id'] ? 'selected' : '' ?>><?= esc($cat['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group" style="margin-bottom: 25px;">
                    <label style="display: block; font-weight: 500; font-size: 14px; color: #666; margin-bottom: 10px;">Experience Level</label>
                    <select name="level" class="form-control" style="width: 100%; padding: 12px 15px; border: 1px solid #eee; border-radius: 6px; font-size: 15px; background: #fff; appearance: none; -webkit-appearance: none; background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23333%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 15px top 50%; background-size: 10px auto;">
                        <option value="">Select Level...</option>
                        <option value="Internship" <?= old('level') === 'Internship' ? 'selected' : '' ?>>Internship</option>
                        <option value="Entry Level" <?= old('level') === 'Entry Level' ? 'selected' : '' ?>>Entry Level</option>
                        <option value="Mid Level" <?= old('level') === 'Mid Level' ? 'selected' : '' ?>>Mid Level</option>
                        <option value="Senior Level" <?= old('level') === 'Senior Level' ? 'selected' : '' ?>>Senior Level</option>
                    </select>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px;">
                    <div class="form-group">
                        <label style="display: block; font-weight: 500; font-size: 14px; color: #666; margin-bottom: 10px;">Salary Min ($)</label>
                        <input type="number" name="salary_min" class="form-control" value="<?= old('salary_min') ?>" placeholder="e.g. 2000" style="width: 100%; padding: 12px 15px; border: 1px solid #eee; border-radius: 6px; font-size: 15px; background: #fff;">
                    </div>

                    <div class="form-group">
                        <label style="display: block; font-weight: 500; font-size: 14px; color: #666; margin-bottom: 10px;">Salary Max ($)</label>
                        <input type="number" name="salary_max" class="form-control" value="<?= old('salary_max') ?>" placeholder="e.g. 4000" style="width: 100%; padding: 12px 15px; border: 1px solid #eee; border-radius: 6px; font-size: 15px; background: #fff;">
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 25px;">
                     <label style="display: block; font-weight: 500; font-size: 14px; color: #666; margin-bottom: 10px;">Experience (Years)</label>
                     <input type="text" name="experience" class="form-control" value="<?= old('experience') ?>" placeholder="e.g. 3-5 Years" style="width: 100%; padding: 12px 15px; border: 1px solid #eee; border-radius: 6px; font-size: 15px; background: #fff;">
                 </div>
                 
                 <div class="form-group" style="margin-bottom: 25px;">
                     <label style="display: block; font-weight: 500; font-size: 14px; color: #666; margin-bottom: 10px;">Education</label>
                     <input type="text" name="education" class="form-control" value="<?= old('education') ?>" placeholder="e.g. Bachelor's Degree in Computer Science" style="width: 100%; padding: 12px 15px; border: 1px solid #eee; border-radius: 6px; font-size: 15px; background: #fff;">
                 </div>
                
                 <div class="form-group" style="margin-bottom: 25px;">
                    <label style="display: block; font-weight: 500; font-size: 14px; color: #666; margin-bottom: 10px;">Location</label>
                    <input type="text" name="location" class="form-control" value="<?= old('location') ?>" placeholder="e.g. Tripoli, Libya" style="width: 100%; padding: 12px 15px; border: 1px solid #eee; border-radius: 6px; font-size: 15px; background: #fff;">
                </div>

                <div class="form-group" style="margin-bottom: 25px;">
                    <label style="display: block; font-weight: 500; font-size: 14px; color: #666; margin-bottom: 10px;">Application Deadline</label>
                    <input type="date" name="deadline" class="form-control" value="<?= old('deadline') ?>" style="width: 100%; padding: 12px 15px; border: 1px solid #eee; border-radius: 6px; font-size: 15px; background: #fff;">
                </div>

                <div class="form-group" style="margin-bottom: 25px;">
                    <label style="display: block; font-weight: 500; font-size: 14px; color: #666; margin-bottom: 10px;">Job Description</label>
                    <textarea name="description" class="form-control" rows="6" placeholder="Describe the job role..." style="width: 100%; padding: 12px 15px; border: 1px solid #eee; border-radius: 6px; font-size: 15px; background: #fff; resize: vertical;"><?= old('description') ?></textarea>
                </div>

                <div class="form-group" style="margin-bottom: 30px;">
                    <label style="display: block; font-weight: 500; font-size: 14px; color: #666; margin-bottom: 10px;">Requirements</label>
                    <textarea name="requirements" class="form-control" rows="6" placeholder="List the requirements..." style="width: 100%; padding: 12px 15px; border: 1px solid #eee; border-radius: 6px; font-size: 15px; background: #fff; resize: vertical;"><?= old('requirements') ?></textarea>
                </div>

                <div style="display: flex; gap: 15px; justify-content: flex-end;">
                    <a href="<?= base_url('company') ?>" style="padding: 12px 30px; border-radius: 8px; font-weight: 600; text-decoration: none; color: #666; background: #f1f1f1; border: 1px solid #ddd; display: inline-block;">Cancel</a>
                    <button type="submit" class="btn btn-primary" style="padding: 12px 30px; border-radius: 8px; font-weight: 600;">Publish Job</button>
                </div>

            </form>
        </div>
    </div>
</div>
