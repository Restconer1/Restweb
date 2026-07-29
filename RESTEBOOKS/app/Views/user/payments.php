<h1 style="margin-bottom:24px;">Payment History</h1>
<div class="glass" style="padding:0;overflow:hidden;">
    <table>
        <thead><tr><th>Reference</th><th>Amount</th><th>Status</th><th>Date</th></tr></thead>
        <tbody>
        <?php foreach ($payments as $p): ?>
            <tr>
                <td><?= htmlspecialchars($p['reference']) ?></td>
                <td>₦<?= number_format((float) $p['amount']) ?></td>
                <td>
                    <?php $badge = ['success' => 'badge-success', 'pending' => 'badge-warning', 'failed' => 'badge-danger'][$p['status']] ?? 'badge-free'; ?>
                    <span class="badge <?= $badge ?>"><?= ucfirst($p['status']) ?></span>
                </td>
                <td><?= date('M j, Y', strtotime($p['created_at'])) ?></td>
            </tr>
        <?php endforeach; ?>
        <?php if (empty($payments)): ?>
            <tr><td colspan="4" style="color:var(--text-muted);">No payments yet.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
