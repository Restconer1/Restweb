<h1 style="margin-bottom:24px;">Welcome back, <?= htmlspecialchars(explode(' ', $user['full_name'])[0]) ?> 👋</h1>

<div class="grid grid-3" style="margin-bottom:32px;">
    <div class="glass stat-card">
        <div class="stat-label">Subscription</div>
        <div class="stat-value" style="font-size:1.3rem;">
            <?php if ($subscription): ?>
                <span class="badge badge-success">Active</span>
            <?php else: ?>
                <span class="badge badge-warning">Inactive</span>
            <?php endif; ?>
        </div>
        <?php if ($subscription): ?>
            <p style="color:var(--text-muted);font-size:0.85rem;margin-top:8px;">Renews <?= date('M j, Y', strtotime($subscription['expires_at'])) ?></p>
        <?php else: ?>
            <a href="/pricing" class="btn btn-primary btn-sm" style="margin-top:10px;">Subscribe — ₦1,000</a>
        <?php endif; ?>
    </div>
    <div class="glass stat-card">
        <div class="stat-label">Total Downloads</div>
        <div class="stat-value"><?= $downloadCount ?></div>
    </div>
    <div class="glass stat-card">
        <div class="stat-label">Account Email</div>
        <div class="stat-value" style="font-size:1.1rem;word-break:break-all;"><?= htmlspecialchars($user['email']) ?></div>
    </div>
</div>

<h2 style="margin-bottom:16px;">Recent Downloads</h2>
<div class="glass" style="padding:0;overflow:hidden;">
    <table>
        <thead><tr><th>Book</th><th>Downloaded</th></tr></thead>
        <tbody>
        <?php foreach ($recentDownloads as $d): ?>
            <tr>
                <td><a href="/books/<?= htmlspecialchars($d['slug']) ?>"><?= htmlspecialchars($d['title']) ?></a></td>
                <td><?= date('M j, Y g:ia', strtotime($d['downloaded_at'])) ?></td>
            </tr>
        <?php endforeach; ?>
        <?php if (empty($recentDownloads)): ?>
            <tr><td colspan="2" style="color:var(--text-muted);">No downloads yet — <a href="/books">browse the library</a>.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
