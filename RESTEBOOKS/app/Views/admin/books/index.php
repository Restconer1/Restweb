<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
    <h1>Manage Books</h1>
    <a href="/admin/books/create" class="btn btn-primary"><i class="fa-solid fa-upload"></i> Upload Ebook</a>
</div>

<div class="glass" style="padding:0;overflow:hidden;">
    <table>
        <thead><tr><th>Title</th><th>Type</th><th>Status</th><th>Downloads</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($books as $b): ?>
            <tr>
                <td><?= htmlspecialchars($b['title']) ?></td>
                <td><?= strtoupper($b['file_type']) ?></td>
                <td>
                    <span class="badge <?= $b['status'] === 'published' ? 'badge-success' : 'badge-warning' ?>">
                        <?= ucfirst($b['status']) ?>
                    </span>
                    <?php if ($b['is_premium']): ?><span class="badge badge-premium">Premium</span><?php endif; ?>
                </td>
                <td><?= (int) $b['downloads_count'] ?></td>
                <td>
                    <form method="POST" action="/admin/books/<?= (int) $b['id'] ?>/delete" onsubmit="return confirm('Delete this book?');" style="display:inline;">
                        <button type="submit" class="btn btn-ghost btn-sm"><i class="fa-solid fa-trash"></i></button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php if (empty($books)): ?>
            <tr><td colspan="5" style="color:var(--text-muted);">No books uploaded yet.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
