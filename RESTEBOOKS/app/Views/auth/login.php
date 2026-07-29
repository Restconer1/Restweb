<div class="glass auth-shell">
    <h2 style="margin-bottom:6px;">Welcome back</h2>
    <p style="color:var(--text-muted);margin-bottom:24px;">Log in to access your library.</p>

    <form method="POST" action="/login">
        <?= \App\Helpers\Csrf::field() ?>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required autofocus>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
            <label style="display:flex;align-items:center;gap:6px;font-size:0.85rem;"><input type="checkbox" name="remember" style="width:auto;"> Remember me</label>
            <a href="/forgot-password" style="font-size:0.85rem;color:var(--neon-purple);">Forgot password?</a>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Login</button>
    </form>

    <p style="text-align:center;margin-top:20px;color:var(--text-muted);font-size:0.9rem;">
        Don't have an account? <a href="/register" style="color:var(--neon-purple);">Create one</a>
    </p>
</div>
