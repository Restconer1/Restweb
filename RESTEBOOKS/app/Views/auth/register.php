<div class="glass auth-shell">
    <h2 style="margin-bottom:6px;">Create your account</h2>
    <p style="color:var(--text-muted);margin-bottom:24px;">Join RESTEBOOKS and start reading.</p>

    <form method="POST" action="/register">
        <?= \App\Helpers\Csrf::field() ?>
        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="full_name" required autofocus>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" minlength="8" required>
        </div>
        <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" minlength="8" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Create Account</button>
    </form>

    <p style="text-align:center;margin-top:20px;color:var(--text-muted);font-size:0.9rem;">
        Already have an account? <a href="/login" style="color:var(--neon-purple);">Login</a>
    </p>
</div>
