<div class="glass auth-shell">
    <h2 style="margin-bottom:6px;">Forgot your password?</h2>
    <p style="color:var(--text-muted);margin-bottom:24px;">Enter your email and we'll send you a reset link.</p>

    <form method="POST" action="/forgot-password">
        <?= \App\Helpers\Csrf::field() ?>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required autofocus>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Send Reset Link</button>
    </form>

    <p style="text-align:center;margin-top:20px;color:var(--text-muted);font-size:0.9rem;">
        <a href="/login" style="color:var(--neon-purple);">&larr; Back to login</a>
    </p>
</div>
