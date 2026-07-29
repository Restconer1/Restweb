<h1 style="margin-bottom:24px;">Subscription</h1>
<div class="glass card" style="max-width:480px;">
    <?php if ($subscription): ?>
        <span class="badge badge-success">Active — Premium</span>
        <p style="margin-top:16px;color:var(--text-muted);">
            Started <?= date('M j, Y', strtotime($subscription['starts_at'])) ?><br>
            Renews/expires <?= date('M j, Y', strtotime($subscription['expires_at'])) ?>
        </p>
        <a href="/payment/initialize" class="btn btn-ghost" style="margin-top:16px;">Renew Now</a>
    <?php else: ?>
        <span class="badge badge-warning">No Active Subscription</span>
        <p style="margin-top:16px;color:var(--text-muted);">Subscribe for ₦1,000/month to unlock unlimited downloads.</p>
        <a href="/pricing" class="btn btn-primary" style="margin-top:16px;">Subscribe Now</a>
    <?php endif; ?>
</div>
