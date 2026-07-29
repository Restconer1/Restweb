<section class="section">
    <div class="container grid grid-2" style="max-width:900px;">
        <div class="glass card">
            <h2 style="margin-bottom:16px;">Get in Touch</h2>
            <form method="POST" action="/contact">
                <?= \App\Helpers\Csrf::field() ?>
                <div class="form-group"><label>Name</label><input type="text" name="name" required></div>
                <div class="form-group"><label>Email</label><input type="email" name="email" required></div>
                <div class="form-group"><label>Message</label><textarea name="message" rows="5" required></textarea></div>
                <button type="submit" class="btn btn-primary btn-block">Send Message</button>
            </form>
        </div>
        <div class="glass card">
            <h2 style="margin-bottom:16px;">Contact Info</h2>
            <p style="color:var(--text-muted);margin-bottom:12px;"><i class="fa-solid fa-envelope"></i> support@restebooks.test</p>
            <p style="color:var(--text-muted);margin-bottom:12px;"><i class="fa-solid fa-phone"></i> +234 000 000 0000</p>
            <p style="color:var(--text-muted);margin-bottom:12px;"><i class="fa-brands fa-whatsapp"></i> Chat on WhatsApp</p>
            <p style="color:var(--text-muted);"><i class="fa-solid fa-location-dot"></i> Kano, Nigeria</p>
        </div>
    </div>
</section>
