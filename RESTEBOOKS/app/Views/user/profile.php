<h1 style="margin-bottom:24px;">My Profile</h1>
<div class="glass card" style="max-width:480px;">
    <form method="POST" action="/dashboard/profile">
        <?= \App\Helpers\Csrf::field() ?>
        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="full_name" value="<?= htmlspecialchars($user['full_name']) ?>">
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" value="<?= htmlspecialchars($user['email']) ?>" disabled>
        </div>
        <div class="form-group">
            <label>Phone</label>
            <input type="text" name="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>">
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>
