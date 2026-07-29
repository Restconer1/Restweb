<h1 style="margin-bottom:24px;">Bookmarks</h1>
<div class="grid grid-3">
    <?php foreach ($bookmarks as $b): ?>
        <div class="glass card">
            <p class="book-title"><?= htmlspecialchars($b['title']) ?></p>
            <p class="book-meta">Page <?= (int) $b['page_number'] ?></p>
            <a href="/books/<?= htmlspecialchars($b['slug']) ?>" class="btn btn-ghost btn-sm">Continue Reading</a>
        </div>
    <?php endforeach; ?>
</div>
<?php if (empty($bookmarks)): ?>
    <div class="glass card" style="text-align:center;padding:40px;color:var(--text-muted);">No bookmarks yet.</div>
<?php endif; ?>
