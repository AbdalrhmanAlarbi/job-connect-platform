<div style="background-color: #F8F9FA; min-height: 100vh; display: flex; width: 100%;">
        
        <!-- Sidebar -->
        <?= view('admin/templates/sidebar') ?>

        <!-- Main Content -->
        <div style="flex: 1; padding: 30px; min-width: 0;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
                <h1 style="font-size: 24px; font-weight: 700; color: #1A1A1A;">User Management</h1>
                <form action="<?= base_url('admin/users') ?>" method="GET">
                    <input type="text" name="q" value="<?= esc($searchQuery ?? '') ?>" placeholder="Search users..." style="padding: 10px 15px; border: 1px solid #eee; border-radius: 8px; width: 300px;">
                </form>
            </div>
            
            <div style="background: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.02); overflow: hidden;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead style="background: #f8f9fa;">
                        <tr>
                            <th style="padding: 15px 20px; text-align: left; font-size: 13px; font-weight: 600; color: #666; text-transform: uppercase;">User</th>
                            <th style="padding: 15px 20px; text-align: left; font-size: 13px; font-weight: 600; color: #666; text-transform: uppercase;">Role</th>
                            <th style="padding: 15px 20px; text-align: left; font-size: 13px; font-weight: 600; color: #666; text-transform: uppercase;">Status</th>
                            <th style="padding: 15px 20px; text-align: right; font-size: 13px; font-weight: 600; color: #666; text-transform: uppercase;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="padding: 20px;">
                                <div style="display: flex; gap: 10px; align-items: center;">
                                    <div style="width: 35px; height: 35px; background: #EBF2FF; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--primary-color); font-weight: 700;">
                                        <?= substr(esc($user['name']), 0, 1) ?>
                                    </div>
                                    <div>
                                        <div style="font-weight: 600; color: #333;">
                                            <?= esc($user['name']) ?>
                                        </div>
                                        <div style="font-size: 12px; color: #888;"><?= esc($user['email']) ?></div>
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 20px;">
                                <span style="background: <?= $user['role'] === 'company' ? '#FFF3E0' : ($user['role'] === 'admin' ? '#F3E5F5' : '#E3F2FD') ?>; color: <?= $user['role'] === 'company' ? '#EF6C00' : ($user['role'] === 'admin' ? '#7B1FA2' : '#1565C0') ?>; padding: 4px 10px; border-radius: 15px; font-size: 12px; font-weight: 600; text-transform: capitalize;">
                                    <?= esc($user['role']) ?>
                                </span>
                            </td>
                            <td style="padding: 20px;">
                                <span style="font-size: 12px; color: #666;"><?= date('M d, Y', strtotime($user['created_at'])) ?></span>
                            </td>
                            <td style="padding: 20px; text-align: right;">
                                <div style="display: flex; gap: 10px; justify-content: flex-end;">
                                    <button onclick="showDeleteModal(<?= $user['id'] ?>)" style="background: none; border: none; font-size: 14px; color: #DC2626; cursor: pointer;" title="Delete">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
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

<!-- Custom Delete Confirmation Modal -->
<div id="deleteModal" style="display: none; position: fixed; inset: 0; background: rgba(0, 0, 0, 0.4); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center; opacity: 0; transition: opacity 0.3s ease;">
    <div style="background: white; width: 400px; border-radius: 16px; padding: 32px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); transform: scale(0.9); transition: transform 0.3s ease; text-align: center;">
        <div style="width: 60px; height: 60px; background: #FEE2E2; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; color: #DC2626;">
            <i class="fa-solid fa-triangle-exclamation" style="font-size: 24px;"></i>
        </div>
        <h3 style="font-size: 20px; font-weight: 700; color: #111827; margin-bottom: 8px;">Delete User</h3>
        <p style="color: #6B7280; font-size: 14px; margin-bottom: 30px; line-height: 1.5;">Are you sure you want to delete this user? This action cannot be undone and all associated data will be permanently removed.</p>
        
        <div style="display: flex; gap: 12px;">
            <button onclick="hideDeleteModal()" style="flex: 1; padding: 12px; border-radius: 10px; border: 1px solid #E5E7EB; background: white; color: #374151; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#F9FAFB'" onmouseout="this.style.background='white'">
                Cancel
            </button>
            <button id="confirmDeleteBtn" style="flex: 1; padding: 12px; border-radius: 10px; border: none; background: #DC2626; color: white; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#B91C1C'" onmouseout="this.style.background='#DC2626'">
                Delete User
            </button>
        </div>
    </div>
</div>

<script>
let userIdToDelete = null;

function showDeleteModal(userId) {
    userIdToDelete = userId;
    const modal = document.getElementById('deleteModal');
    const content = modal.querySelector('div');
    
    modal.style.display = 'flex';
    // Small timeout to allow display:flex to apply before opacity transition
    setTimeout(() => {
        modal.style.opacity = '1';
        content.style.transform = 'scale(1)';
    }, 10);
}

function hideDeleteModal() {
    const modal = document.getElementById('deleteModal');
    const content = modal.querySelector('div');
    
    modal.style.opacity = '0';
    content.style.transform = 'scale(0.9)';
    
    setTimeout(() => {
        modal.style.display = 'none';
        userIdToDelete = null;
    }, 300);
}

document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
    if (userIdToDelete) {
        window.location.href = '<?= base_url('admin/delete-user/') ?>' + userIdToDelete;
    }
});

// Close modal on outside click
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        hideDeleteModal();
    }
});
</script>
