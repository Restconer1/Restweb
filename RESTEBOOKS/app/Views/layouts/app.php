<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'RESTEBOOKS') ?></title>
    <meta name="description" content="RESTEBOOKS — read and download premium ebooks after subscribing for ₦1,000.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body>

<nav class="navbar">
    <div class="container">
        <a href="/" class="brand">RESTEBOOKS</a>
        <div class="nav-links">
            <a href="/books">Browse Books</a>
            <a href="/pricing">Pricing</a>
            <a href="/about">About</a>
            <a href="/contact">Contact</a>
            <?php if (\App\Core\Auth::checkUser()): ?>
                <a href="/dashboard" class="btn btn-ghost btn-sm"><i class="fa-solid fa-gauge"></i> Dashboard</a>
            <?php else: ?>
                <a href="/login">Login</a>
                <a href="/register" class="btn btn-primary btn-sm">Get Started</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<main>
    <div class="container" style="padding-top:20px;">
        <?php if ($msg = $this->flash('error')): ?>
            <div class="alert alert-error"><i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($msg) ?></div>
        <?php endif; ?>
        <?php if ($msg = $this->flash('success')): ?>
            <div class="alert alert-success"><i class="fa-solid fa-circle-check"></i> <?= htmlspecialchars($msg) ?></div>
        <?php endif; ?>
        <?php if ($msg = $this->flash('paywall')): ?>
            <div class="alert alert-paywall"><i class="fa-solid fa-lock"></i> <?= htmlspecialchars($msg) ?></div>
        <?php endif; ?>
    </div>

    <?= $content ?>
</main>

<footer class="site-footer">
    <div class="container">
        <div class="grid grid-4">
            <div>
                <div class="brand" style="margin-bottom:10px;">RESTEBOOKS</div>
                <p>Your premium digital library. Unlimited ebook downloads for ₦1,000/month.</p>
            </div>
            <div>
                <h4 style="font-size:0.9rem;color:#fff;">Quick Links</h4>
                <p><a href="/books">Browse Books</a></p>
                <p><a href="/pricing">Pricing</a></p>
                <p><a href="/faq">Help Center</a></p>
            </div>
            <div>
                <h4 style="font-size:0.9rem;color:#fff;">Legal</h4>
                <p><a href="/faq">Terms of Service</a></p>
                <p><a href="/faq">Privacy Policy</a></p>
                <p><a href="/faq">Refund Policy</a></p>
            </div>
            <div>
                <h4 style="font-size:0.9rem;color:#fff;">Connect</h4>
                <p><i class="fa-solid fa-envelope"></i> support@restebooks.test</p>
                <p><i class="fa-brands fa-whatsapp"></i> Chat on WhatsApp</p>
            </div>
        </div>
        <p style="margin-top:24px;">&copy; <?= date('Y') ?> RESTEBOOKS. All rights reserved.</p>
    </div>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script src="/assets/js/app.js"></script>
</body>
</html>
