<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'RESTEBOOKS Admin') ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js" as="script">
    <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body>

<nav class="navbar">
    <div class="container">
        <a href="/admin/dashboard" class="brand">RESTEBOOKS <span style="font-size:0.7rem;color:var(--text-muted);font-weight:500;">ADMIN</span></a>
        <div class="nav-links">
            <a href="/" target="_blank">View Site</a>
            <form method="POST" action="/admin/logout" style="display:inline;">
                <button type="submit" class="btn btn-ghost btn-sm"><i class="fa-solid fa-right-from-bracket"></i> Logout</button>
            </form>
        </div>
    </div>
</nav>

<div class="dash-shell">
    <aside class="dash-sidebar">
        <?php $route = strtok($_SERVER['REQUEST_URI'], '?'); ?>
        <a href="/admin/dashboard" class="<?= $route === '/admin/dashboard' ? 'active' : '' ?>"><i class="fa-solid fa-gauge"></i> Dashboard</a>
        <a href="/admin/books" class="<?= str_starts_with($route, '/admin/books') ? 'active' : '' ?>"><i class="fa-solid fa-book"></i> Manage Books</a>
        <a href="/admin/users" class="<?= str_starts_with($route, '/admin/users') ? 'active' : '' ?>"><i class="fa-solid fa-users"></i> Manage Users</a>
        <a href="#"><i class="fa-solid fa-tags"></i> Categories</a>
        <a href="#"><i class="fa-solid fa-money-bill-wave"></i> Payments</a>
        <a href="#"><i class="fa-solid fa-chart-line"></i> Analytics</a>
        <a href="#"><i class="fa-solid fa-newspaper"></i> Blog</a>
        <a href="#"><i class="fa-solid fa-clipboard-list"></i> Activity Logs</a>
        <a href="#"><i class="fa-solid fa-gear"></i> Settings</a>
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
