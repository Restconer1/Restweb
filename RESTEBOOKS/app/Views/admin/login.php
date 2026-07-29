<div class="glass auth-shell">
    <h2 style="margin-bottom:6px;">Admin Login</h2>
    <p style="color:var(--text-muted);margin-bottom:24px;">RESTEBOOKS control panel.</p>
    <form method="POST" action="/admin/login">
        <?= \App\Helpers\Csrf::field() ?>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required autofocus>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Login</button>
    </form>
</div>
