<section class="section" style="padding-top:20px;">
    <div class="container">
        <h1 style="margin-bottom:24px;">Browse Books</h1>

        <form id="browse-filter-form" method="GET" action="/books" class="glass card" style="display:flex;gap:14px;flex-wrap:wrap;margin-bottom:28px;">
            <input type="text" name="q" placeholder="Search by title or author..." value="<?= htmlspecialchars($filters['q'] ?? '') ?>" style="flex:2;min-width:220px;">
            <select name="category" style="flex:1;min-width:160px;">
                <option value="">All Categories</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= htmlspecialchars($cat['slug']) ?>" <?= ($filters['category'] ?? '') === $cat['slug'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <select name="sort" style="flex:1;min-width:160px;">
                <option value="newest" <?= ($filters['sort'] ?? '') === 'newest' ? 'selected' : '' ?>>Newest</option>
                <option value="downloads" <?= ($filters['sort'] ?? '') === 'downloads' ? 'selected' : '' ?>>Most Downloaded</option>
                <option value="rating" <?= ($filters['sort'] ?? '') === 'rating' ? 'selected' : '' ?>>Highest Rated</option>
            </select>
            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i> Search</button>
        </form>

        <div class="grid grid-4">
            <?php foreach ($books as $book): ?>
                <?php include __DIR__ . '/_card.php'; ?>
            <?php endforeach; ?>
        </div>

        <?php if (empty($books)): ?>
            <div class="glass card" style="text-align:center;padding:48px;">
                <p style="color:var(--text-muted);">No books match your search yet. Try a different keyword or category.</p>
            </div>
        <?php endif; ?>

        <div style="display:flex;justify-content:center;gap:12px;margin-top:32px;">
            <?php if ($page > 1): ?>
                <a class="btn btn-ghost btn-sm" href="?page=<?= $page - 1 ?>">&larr; Previous</a>
            <?php endif; ?>
            <?php if (count($books) === 12): ?>
                <a class="btn btn-ghost btn-sm" href="?page=<?= $page + 1 ?>">Next &rarr;</a>
            <?php endif; ?>
        </div>
    </div>
</section>
