<h1 style="margin-bottom:24px;">Admin Dashboard</h1>

<div class="grid grid-4" style="margin-bottom:32px;">
    <div class="glass stat-card">
        <div class="stat-label">Total Users</div>
        <div class="stat-value"><?= (int) $stats['total_users'] ?></div>
    </div>
    <div class="glass stat-card">
        <div class="stat-label">Active Subscribers</div>
        <div class="stat-value"><?= (int) $stats['active_subscribers'] ?></div>
    </div>
    <div class="glass stat-card">
        <div class="stat-label">Total Revenue</div>
        <div class="stat-value">₦<?= number_format((float) $stats['total_revenue']) ?></div>
    </div>
    <div class="glass stat-card">
        <div class="stat-label">Books Uploaded</div>
        <div class="stat-value"><?= (int) $stats['books_uploaded'] ?></div>
    </div>
</div>

<div class="grid grid-2" style="margin-bottom:32px;">
    <div class="glass card">
        <h3 style="margin-bottom:16px;">Monthly Income</h3>
        <canvas id="incomeChart" height="180"></canvas>
    </div>
    <div class="glass card">
        <h3 style="margin-bottom:16px;">Most Downloaded Books</h3>
        <table>
            <?php foreach ($mostDownloaded as $b): ?>
                <tr><td><?= htmlspecialchars($b['title']) ?></td><td style="text-align:right;"><?= (int) $b['downloads_count'] ?></td></tr>
            <?php endforeach; ?>
            <?php if (empty($mostDownloaded)): ?><tr><td style="color:var(--text-muted);">No downloads recorded yet.</td></tr><?php endif; ?>
        </table>
    </div>
</div>

<div class="grid grid-2">
    <div class="glass card">
        <h3 style="margin-bottom:16px;">Recent Payments</h3>
        <table>
            <thead><tr><th>User</th><th>Amount</th><th>Status</th></tr></thead>
            <tbody>
            <?php foreach ($recentPayments as $p): ?>
                <tr>
                    <td><?= htmlspecialchars($p['full_name']) ?></td>
                    <td>₦<?= number_format((float) $p['amount']) ?></td>
                    <td><?= htmlspecialchars($p['status']) ?></td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($recentPayments)): ?><tr><td colspan="3" style="color:var(--text-muted);">No payments yet.</td></tr><?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="glass card">
        <h3 style="margin-bottom:16px;">Recent Users</h3>
        <table>
            <thead><tr><th>Name</th><th>Email</th><th>Joined</th></tr></thead>
            <tbody>
            <?php foreach ($recentUsers as $u): ?>
                <tr>
                    <td><?= htmlspecialchars($u['full_name']) ?></td>
                    <td><?= htmlspecialchars($u['email']) ?></td>
                    <td><?= date('M j', strtotime($u['created_at'])) ?></td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($recentUsers)): ?><tr><td colspan="3" style="color:var(--text-muted);">No users yet.</td></tr><?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
new Chart(document.getElementById('incomeChart'), {
    type: 'line',
    data: {
        labels: <?= json_encode(array_column($monthlyIncome, 'month')) ?>,
        datasets: [{
            label: 'Revenue (₦)',
            data: <?= json_encode(array_map('floatval', array_column($monthlyIncome, 'total'))) ?>,
            borderColor: '#8B5CF6',
            backgroundColor: 'rgba(139,92,246,0.15)',
            tension: 0.35,
            fill: true,
        }]
    },
    options: {
        plugins: { legend: { labels: { color: '#9797B3' } } },
        scales: {
            x: { ticks: { color: '#9797B3' }, grid: { color: 'rgba(255,255,255,0.05)' } },
            y: { ticks: { color: '#9797B3' }, grid: { color: 'rgba(255,255,255,0.05)' } }
        }
    }
});
</script>
