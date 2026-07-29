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
<div class="container">
    <?php if ($msg = $this->flash('error')): ?>
        <div class="alert alert-error" style="max-width:440px;margin:24px auto 0;"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>
    <?php if ($msg = $this->flash('success')): ?>
        <div class="alert alert-success" style="max-width:440px;margin:24px auto 0;"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>
    <?= $content ?>
</div>
</body>
</html>
