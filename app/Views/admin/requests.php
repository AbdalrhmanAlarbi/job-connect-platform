<div style="background-color: #F8F9FA; min-height: 100vh; display: flex; width: 100%;">
        
        <!-- Sidebar -->
        <?= view('admin/templates/sidebar') ?>

        <!-- Main Content -->
        <div style="flex: 1; padding: 30px; min-width: 0;">
            <h1 style="font-size: 24px; font-weight: 700; margin-bottom: 30px; color: #1A1A1A;">Company Verification Requests</h1>
            
            <?php if(session()->getFlashdata('success')): ?>
                <div style="background: #D4EDDA; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <?php if(session()->getFlashdata('error')): ?>
                <div style="background: #F8D7DA; color: #721C24; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <div style="background: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.02); overflow: hidden;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead style="background: #f8f9fa;">
                        <tr>
                            <th style="padding: 15px 20px; text-align: left; font-size: 13px; font-weight: 600; color: #666; text-transform: uppercase;">Company Name</th>
                            <th style="padding: 15px 20px; text-align: left; font-size: 13px; font-weight: 600; color: #666; text-transform: uppercase;">Registration Date</th>
                            <th style="padding: 15px 20px; text-align: left; font-size: 13px; font-weight: 600; color: #666; text-transform: uppercase;">Website URL</th>
                            <th style="padding: 15px 20px; text-align: right; font-size: 13px; font-weight: 600; color: #666; text-transform: uppercase;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($requests as $req): ?>
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="padding: 20px;">
                                <div style="font-weight: 600; color: #333;"><?= esc($req['name']) ?></div>
                                <div style="font-size: 12px; color: #888;"><?= esc($req['email']) ?></div>
                            </td>
                            <td style="padding: 20px; color: #555;"><?= date('M d, Y', strtotime($req['created_at'])) ?></td>
                            <td style="padding: 20px;">
                                <?php if($req['website']): ?>
                                <a href="<?= esc($req['website']) ?>" target="_blank" style="color: var(--primary-color); text-decoration: none; font-size: 13px; display: inline-flex; align-items: center; gap: 5px;">
                                    <i class="fa-solid fa-globe"></i> <?= esc($req['website']) ?>
                                </a>
                                <?php else: ?>
                                <span style="color: #888; font-size: 13px;">N/A</span>
                                <?php endif; ?>
                            </td>
                            <td style="padding: 20px; text-align: right;">
                                <div style="display: flex; gap: 10px; justify-content: flex-end;">
                                    <a href="<?= base_url('admin/approve/'.$req['id']) ?>" style="background: #E8F5E9; color: #2E7D32; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 12px; font-weight: 600;">Approve</a>
                                    <a href="<?= base_url('admin/reject/'.$req['id']) ?>" style="background: #FEF2F2; color: #DC2626; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 12px; font-weight: 600;">Reject</a>
                                    </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
