<section class="section" style="text-align:center;">
    <div class="container">
        <h1>Simple, Premium Pricing</h1>
        <p style="color:var(--text-muted);max-width:480px;margin:0 auto 40px;">One plan. Unlimited downloads. No hidden fees.</p>

        <div class="glass card" style="max-width:420px;margin:0 auto;padding:44px;">
            <span class="badge badge-premium">Premium</span>
            <div style="font-family:var(--font-display);font-size:3rem;font-weight:700;margin:16px 0 4px;">
                ₦<?= number_format($price) ?><span style="font-size:1rem;color:var(--text-muted);">/month</span>
            </div>

            <ul style="list-style:none;padding:0;margin:28px 0;text-align:left;color:var(--text-muted);">
                <li style="margin-bottom:12px;"><i class="fa-solid fa-check" style="color:#4ade80;"></i> Unlimited Downloads</li>
                <li style="margin-bottom:12px;"><i class="fa-solid fa-check" style="color:#4ade80;"></i> All Premium Books</li>
                <li style="margin-bottom:12px;"><i class="fa-solid fa-check" style="color:#4ade80;"></i> Latest Uploads First</li>
                <li style="margin-bottom:12px;"><i class="fa-solid fa-check" style="color:#4ade80;"></i> Reading History & Bookmarks</li>
                <li style="margin-bottom:12px;"><i class="fa-solid fa-check" style="color:#4ade80;"></i> Priority Support</li>
            </ul>

            <a href="/payment/initialize" class="btn btn-primary btn-block"><i class="fa-solid fa-crown"></i> Subscribe Now</a>
            <p style="font-size:0.78rem;color:var(--text-muted);margin-top:14px;">
                Secured by Paystack. <?php if (!empty($book)): ?>Redirecting you back to “<?= htmlspecialchars($book) ?>” after payment.<?php endif; ?>
            </p>
        </div>
    </div>
</section>
