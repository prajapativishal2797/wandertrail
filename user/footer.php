</main>
<footer class="eg-user-footer">
    <div><span>&copy; <?= date('Y') ?> WanderTrail</span>
        <nav><a href="../destinations.php">Destinations</a><a href="../packages.php">Packages</a><a
                    href="../enquiry.php">Plan a trip</a><a href="feedback.php">Feedback</a><a href="complain.php">Support</a>
        </nav>
    </div>
</footer>
<script src="../assets/user/js/jquery.min.js"></script>
<script src="../assets/user/js/bootstrap.js"></script>
<script src="../assets/user/js/script.js?v=20260824-1"></script>
<script>document.querySelector('.eg-user-nav-toggle')?.addEventListener('click', function () {
        const open = this.getAttribute('aria-expanded') === 'true';
        this.setAttribute('aria-expanded', String(!open));
        document.querySelector('.eg-user-nav')?.classList.toggle('is-open', !open)
    });</script></body></html>
