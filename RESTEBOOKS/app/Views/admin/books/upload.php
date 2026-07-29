<h1 style="margin-bottom:24px;">Upload Ebook</h1>

<div class="glass card" style="max-width:640px;">
    <form method="POST" action="/admin/books" enctype="multipart/form-data">
        <?= \App\Helpers\Csrf::field() ?>

        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" required>
        </div>

        <div class="grid grid-2">
            <div class="form-group">
                <label>Category</label>
                <select name="category_id">
                    <option value="">Select category</option>
                    <?php foreach ($categories as $c): ?>
                        <option value="<?= (int) $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Author</label>
                <select name="author_id">
                    <option value="">Select author</option>
                    <?php foreach ($authors as $a): ?>
                        <option value="<?= (int) $a['id'] ?>"><?= htmlspecialchars($a['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description" rows="4"></textarea>
        </div>

        <div class="grid grid-2">
            <div class="form-group">
                <label>Language</label>
                <input type="text" name="language" value="English">
            </div>
            <div class="form-group">
                <label>Pages</label>
                <input type="number" name="pages" min="1">
            </div>
        </div>

        <div class="grid grid-2">
            <div class="form-group">
                <label>Ebook File (PDF, EPUB, DOCX, ZIP, RAR — max 100MB)</label>
                <input type="file" name="ebook_file" accept=".pdf,.epub,.docx,.zip,.rar">
            </div>
            <div class="form-group">
                <label>Cover Image (JPG, PNG, WEBP — max 5MB)</label>
                <input type="file" name="cover_image" accept=".jpg,.jpeg,.png,.webp">
            </div>
        </div>

        <div class="grid grid-2">
            <div class="form-group">
                <label>Status</label>
                <select name="status">
                    <option value="draft">Draft</option>
                    <option value="published">Published</option>
                </select>
            </div>
            <div class="form-group" style="display:flex;gap:20px;align-items:center;padding-top:22px;">
                <label style="display:flex;align-items:center;gap:6px;"><input type="checkbox" name="is_premium" value="1" checked style="width:auto;"> Premium</label>
                <label style="display:flex;align-items:center;gap:6px;"><input type="checkbox" name="is_featured" value="1" style="width:auto;"> Featured</label>
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Upload Ebook</button>
    </form>
</div>
