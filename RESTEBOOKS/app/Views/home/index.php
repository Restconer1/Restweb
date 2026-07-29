<section class="hero">
    <div class="container" style="position:relative;">
        <i class="fa-solid fa-book floaty" style="top:10%;left:8%;font-size:2rem;color:#8B5CF6;"></i>
        <i class="fa-solid fa-file-pdf floaty" style="top:20%;right:10%;font-size:2.4rem;color:#EC4899;animation-delay:1s;"></i>
        <i class="fa-solid fa-cloud-arrow-down floaty" style="bottom:15%;left:14%;font-size:2rem;color:#3B82F6;animation-delay:2s;"></i>
        <i class="fa-solid fa-file-epub floaty" style="bottom:10%;right:16%;font-size:1.8rem;color:#8B5CF6;animation-delay:1.5s;"></i>

        <h1 data-aos="fade-up">RESTEBOOKS</h1>
        <p class="subtitle" data-aos="fade-up" data-aos-delay="100">Your Premium Digital Library.</p>
        <p class="desc" data-aos="fade-up" data-aos-delay="150">Read and download premium ebooks after subscribing for only ₦1,000.</p>
        <div class="hero-actions" data-aos="fade-up" data-aos-delay="200">
            <a href="/books" class="btn btn-primary"><i class="fa-solid fa-book-open"></i> Browse Books</a>
            <a href="/pricing" class="btn btn-ghost"><i class="fa-solid fa-crown"></i> Subscribe Now</a>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-head">
            <h2>Explore Categories</h2>
        </div>
        <div style="display:flex;flex-wrap:wrap;gap:12px;">
            <?php foreach ($categories as $cat): ?>
                <a href="/books?category=<?= urlencode($cat['slug']) ?>" class="chip">
                    <i class="fa-solid <?= htmlspecialchars($cat['icon'] ?: 'fa-book') ?>"></i>
                    <?= htmlspecialchars($cat['name']) ?>
                </a>
            <?php endforeach; ?>
            <?php if (empty($categories)): ?>
                <p style="color:var(--text-muted);">Categories will appear here once seeded — run <code>database/seeders/seed.sql</code>.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-head">
            <h2>Featured Ebooks</h2>
            <a href="/books" class="btn btn-ghost btn-sm">View All <i class="fa-solid fa-arrow-right"></i></a>
        </div>
        <div class="grid grid-4">
            <?php foreach ($featured as $book): ?>
                <?php include __DIR__ . '/../books/_card.php'; ?>
            <?php endforeach; ?>
            <?php if (empty($featured)): ?>
                <p style="color:var(--text-muted);">No featured ebooks yet — upload some from the admin dashboard.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="section">
    <div class="container glass card" style="text-align:center;padding:60px;">
        <h2 style="margin-bottom:8px;">Unlimited Downloads for ₦1,000</h2>
        <p style="color:var(--text-muted);margin-bottom:24px;">One simple plan. Every premium book. Cancel anytime.</p>
        <a href="/pricing" class="btn btn-primary">See Pricing</a>
    </div>
</section>
