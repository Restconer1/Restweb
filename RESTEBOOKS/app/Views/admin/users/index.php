<h1 style="margin-bottom:24px;">Manage Users</h1>

<div class="glass" style="padding:0;overflow:hidden;">
    <table>
        <thead><tr><th>Name</th><th>Email</th><th>Status</th><th>Joined</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($users as $u): ?>
            <tr>
                <td><?= htmlspecialchars($u['full_name']) ?></td>
                <td><?= htmlspecialchars($u['email']) ?></td>
                <td>
                    <?php $badge = ['active' => 'badge-success', 'suspended' => 'badge-danger'][$u['status']] ?? 'badge-free'; ?>
                    <span class="badge <?= $badge ?>"><?= ucfirst($u['status']) ?></span>
                </td>
                <td><?= date('M j, Y', strtotime($u['created_at'])) ?></td>
                <td style="display:flex;gap:8px;">
                    <?php if ($u['status'] === 'active'): ?>
                        <form method="POST" action="/admin/users/<?= (int) $u['id'] ?>/suspend">
                            <button type="submit" class="btn btn-ghost btn-sm">Suspend</button>
                        </form>
                    <?php else: ?>
                        <form method="POST" action="/admin/users/<?= (int) $u['id'] ?>/activate">
                            <button type="submit" class="btn btn-ghost btn-sm">Reactivate</button>
                        </form>
                    <?php endif; ?>
                    <form method="POST" action="/admin/users/<?= (int) $u['id'] ?>/delete" onsubmit="return confirm('Delete this user permanently?');">
                        <button type="submit" class="btn btn-ghost btn-sm"><i class="fa-solid fa-trash"></i></button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php if (empty($users)): ?>
            <tr><td colspan="5" style="color:var(--text-muted);">No users yet.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
