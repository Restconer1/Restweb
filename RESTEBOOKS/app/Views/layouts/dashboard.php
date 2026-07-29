<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'RESTEBOOKS') ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body>

<nav class="navbar">
    <div class="container">
        <a href="/" class="brand">RESTEBOOKS</a>
        <div class="nav-links">
            <a href="/books">Browse Books</a>
            <form method="POST" action="/logout" style="display:inline;">
                <button type="submit" class="btn btn-ghost btn-sm"><i class="fa-solid fa-right-from-bracket"></i> Logout</button>
            </form>
        </div>
    </div>
</nav>

<div class="dash-shell">
    <aside class="dash-sidebar">
        <?php $route = strtok($_SERVER['REQUEST_URI'], '?'); ?>
        <a href="/dashboard" class="<?= $route === '/dashboard' ? 'active' : '' ?>"><i class="fa-solid fa-gauge"></i> Dashboard</a>
        <a href="/dashboard/library" class="<?= $route === '/dashboard/library' ? 'active' : '' ?>"><i class="fa-solid fa-book"></i> My Library</a>
        <a href="/dashboard/bookmarks" class="<?= $route === '/dashboard/bookmarks' ? 'active' : '' ?>"><i class="fa-solid fa-bookmark"></i> Bookmarks</a>
        <a href="/dashboard/subscription" class="<?= $route === '/dashboard/subscription' ? 'active' : '' ?>"><i class="fa-solid fa-crown"></i> Subscription</a>
        <a href="/dashboard/payments" class="<?= $route === '/dashboard/payments' ? 'active' : '' ?>"><i class="fa-solid fa-receipt"></i> Payment History</a>
        <a href="/dashboard/profile" class="<?= $route === '/dashboard/profile' ? 'active' : '' ?>"><i class="fa-solid fa-user"></i> Profile</a>
    </aside>
    <div class="dash-content">
        <?php if ($msg = $this->flash('error')): ?>
            <div class="alert alert-error"><?= htmlspecialchars($msg) ?></div>
        <?php endif; ?>
        <?php if ($msg = $this->flash('success')): ?>
            <div class="alert alert-success"><?= htmlspecialchars($msg) ?></div>
        <?php endif; ?>
        <?= $content ?>
    </div>
</div>

<script src="/assets/js/app.js"></script>
</body>
</html>
