<h1 style="margin-bottom:24px;">My Library</h1>
<div class="glass" style="padding:0;overflow:hidden;">
    <table>
        <thead><tr><th>Book</th><th>Downloaded</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($downloads as $d): ?>
            <tr>
                <td><?= htmlspecialchars($d['title']) ?></td>
                <td><?= date('M j, Y', strtotime($d['downloaded_at'])) ?></td>
                <td><a href="/books/<?= htmlspecialchars($d['slug']) ?>/download" class="btn btn-ghost btn-sm"><i class="fa-solid fa-download"></i> Re-download</a></td>
            </tr>
        <?php endforeach; ?>
        <?php if (empty($downloads)): ?>
            <tr><td colspan="3" style="color:var(--text-muted);">Your library is empty — <a href="/books">browse ebooks</a> to get started.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
