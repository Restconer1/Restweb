<div class="glass card" data-aos="fade-up">
    <div class="book-cover">
        <?php if (!empty($book['cover_path'])): ?>
            <img src="/uploads/covers/<?= htmlspecialchars($book['cover_path']) ?>" alt="<?= htmlspecialchars($book['title']) ?> cover">
        <?php else: ?>
            <i class="fa-solid fa-book"></i>
        <?php endif; ?>
    </div>
    <p class="book-title"><?= htmlspecialchars($book['title']) ?></p>
    <p class="book-meta"><?= htmlspecialchars($book['author_name'] ?? 'Unknown author') ?> · <?= htmlspecialchars($book['category_name'] ?? 'General') ?></p>
    <div class="book-foot">
        <span class="badge <?= $book['is_premium'] ? 'badge-premium' : 'badge-free' ?>">
            <?= $book['is_premium'] ? 'Premium' : 'Free' ?>
        </span>
        <a href="/books/<?= htmlspecialchars($book['slug']) ?>" class="btn btn-ghost btn-sm">View</a>
    </div>
</div>
