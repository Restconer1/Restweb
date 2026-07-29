<div class="glass auth-shell">
    <h2 style="margin-bottom:6px;">Reset your password</h2>
    <p style="color:var(--text-muted);margin-bottom:24px;">Choose a new password below.</p>

    <form method="POST" action="/reset-password">
        <?= \App\Helpers\Csrf::field() ?>
        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
        <div class="form-group">
            <label>New Password</label>
            <input type="password" name="password" minlength="8" required autofocus>
        </div>
        <div class="form-group">
            <label>Confirm New Password</label>
            <input type="password" name="password_confirmation" minlength="8" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
    </form>
</div>
