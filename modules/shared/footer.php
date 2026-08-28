<footer class="eg-public-footer">
    <div class="eg-public-footer__inner">
        <div class="eg-footer-about"><a class="eg-brand eg-brand--footer" href="index.php"><span class="eg-brand-mark">WT</span><span><strong>WanderTrail</strong><small>Trails to the places maps forget.</small></span></a>
            <p>Plan memorable journeys and discover famous sights, hidden gems, picnic places and stays shaped by local landscapes, heritage and people.</p></div>
        <div><h2>Discover</h2><a href="destinations.php">Destinations</a><a href="packages.php">Packages</a><a
                    href="hotels.php">Hotels</a><a href="guides.php">Local guides</a></div>
        <div><h2>Plan</h2><a href="distancecalculator.php">Distance calculator</a><a href="currencyconverter.php">Currency
                converter</a><a href="faq.php">FAQs</a><a href="suggest.php">Suggest a place</a></div>
        <div><h2>WanderTrail</h2><a href="aboutus.php">About us</a><a href="login.php">Sign in</a><a
                    href="register.php">Create account</a><a href="mailto:hello@wandertrail.com">Contact us</a></div>
    </div>
    <div class="eg-public-footer__bottom">
        <div><span>&copy; <?= date('Y') ?> WanderTrail</span><span>Discovery, booking &amp; trip planning.</span></div>
    </div>
</footer>
<button id="scroll-top" type="button" aria-label="Back to top"><i class="fa fa-angle-up"></i></button>
<script src="<?= asset('site/js/jquery.min.js') ?>"></script>
<script src="<?= asset('site/js/jquery-ui.min.js') ?>"></script>
<script src="<?= asset('site/js/bootstrap.js') ?>"></script>
<script src="<?= asset('site/js/owl.carousel.js') ?>"></script>
<script src="<?= asset('site/js/jquery.sticky.js') ?>"></script>
<script src="<?= asset('site/js/jquery.fancybox.pack.js') ?>"></script>
<script src="<?= asset('site/js/jquery.fancybox-media.js') ?>"></script>
<script src="<?= asset('site/js/isotope.pkgd.min.js') ?>"></script>
<script src="<?= asset('site/js/imagesloaded.pkgd.min.js') ?>"></script>
<script src="<?= asset('site/js/masonry.pkgd.min.js') ?>"></script>
<script src="<?= asset('site/js/jquery.validate.min.js') ?>"></script>
<script src="<?= asset('site/js/jquery.form.min.js') ?>"></script>
<script src="<?= asset('site/js/script.js?v=20260817-4') ?>"></script>
<script src="<?= asset('site/js/jquery.scrollTo.min.js') ?>"></script>
<script src="<?= asset('site/js/jquery.flexslider.js') ?>"></script>
<script>document.querySelector('.eg-nav-toggle')?.addEventListener('click', function () {
        const open = this.getAttribute('aria-expanded') === 'true';
        this.setAttribute('aria-expanded', String(!open));
        document.querySelector('.eg-public-nav')?.classList.toggle('is-open', !open);
    });</script></body></html>
