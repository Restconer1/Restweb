<section class="section">
    <div class="container grid grid-2" style="align-items:start;gap:40px;">
        <div class="glass card">
            <div class="book-cover" style="max-width:320px;">
                <?php if (!empty($book['cover_path'])): ?>
                    <img src="/uploads/covers/<?= htmlspecialchars($book['cover_path']) ?>" alt="<?= htmlspecialchars($book['title']) ?> cover">
                <?php else: ?>
                    <i class="fa-solid fa-book"></i>
                <?php endif; ?>
            </div>
        </div>

        <div>
            <span class="badge <?= $book['is_premium'] ? 'badge-premium' : 'badge-free' ?>"><?= $book['is_premium'] ? 'Premium' : 'Free' ?></span>
            <h1 style="margin:12px 0 4px;"><?= htmlspecialchars($book['title']) ?></h1>
            <p style="color:var(--text-muted);margin-bottom:20px;">
                by <?= htmlspecialchars($book['author_name'] ?? 'Unknown author') ?> · <?= htmlspecialchars($book['category_name'] ?? 'General') ?>
            </p>

            <div class="glass card" style="display:flex;gap:28px;flex-wrap:wrap;margin-bottom:24px;">
                <div><div class="stat-label">Language</div><strong><?= htmlspecialchars($book['language']) ?></strong></div>
                <div><div class="stat-label">Pages</div><strong><?= htmlspecialchars((string) ($book['pages'] ?? '—')) ?></strong></div>
                <div><div class="stat-label">File Size</div><strong><?= $book['file_size_kb'] ? round($book['file_size_kb'] / 1024, 1) . ' MB' : '—' ?></strong></div>
                <div><div class="stat-label">Downloads</div><strong><?= (int) $book['downloads_count'] ?></strong></div>
            </div>

            <p style="color:var(--text-primary);line-height:1.7;margin-bottom:28px;">
                <?= nl2br(htmlspecialchars($book['description'] ?? 'No description provided yet.')) ?>
            </p>

            <div style="display:flex;gap:14px;">
                <a href="/books/<?= htmlspecialchars($book['slug']) ?>/download" class="btn btn-primary"><i class="fa-solid fa-download"></i> Download</a>
                <button class="btn btn-ghost" disabled title="Reader coming soon"><i class="fa-solid fa-eye"></i> Preview</button>
            </div>
        </div>
    </div>
</section>
