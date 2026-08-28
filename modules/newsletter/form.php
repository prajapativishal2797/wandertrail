<section class="eg-home-section eg-newsletter-section">
    <div class="eg-section-inner eg-newsletter-panel">
        <div><p class="eg-kicker eg-kicker--dark">Travel notes</p>
            <h2>A world of discovery in your inbox.</h2>
            <p>Seasonal ideas, new journeys and useful local finds from around the world. No clutter.</p></div>
        <div><?php if ($message): ?>
                <div class="eg-alert eg-alert-success"><?= e($message) ?></div><?php endif; ?><?php if ($error): ?>
                <div class="eg-alert eg-alert-danger"><?= e($error) ?></div><?php endif; ?>
            <form method="post" class="eg-newsletter-form"><?= csrf_field() ?><label for="newsletter-email">Email
                    address</label>
                <div><input id="newsletter-email" type="email" name="email_id" placeholder="you@example.com" required>
                    <button type="submit">Subscribe</button>
                </div>
            </form>
        </div>
    </div>
</section>
