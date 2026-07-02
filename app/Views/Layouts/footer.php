<footer class="bg-primary text-light border-top mt-5 pt-5 pb-3">
    <div class="container">
        <div class="row row-cols-1 row-cols-md-3">
            <!-- Brand -->
            <div class="col-md-3 mb-4">
                <h5>MyOnlineShop</h5>
                <p class="text-muted small">
                    My programming exercise projects
                </p>
            </div>

            <!-- Links -->
            <div class="col-md-3 mb-4">
                <h6>Quick Links</h6>
                <ul class="list-unstyled">
                    <li><a class="text-decoration-none text-light" href="<?= base_url('about') ?>">About</a></li>
                    <li><a class="text-decoration-none text-light" href="<?= base_url('contact') ?>">Contact</a></li>
                    <li><a class="text-decoration-none text-light" href="<?= base_url('terms') ?>">Terms</a></li>
                </ul>
            </div>

            <!-- Social -->
            <div class="col-md-3 mb-4">
                <h6>Stay Updated</h6>
                <div class="d-flex gap-3">
                    <a class="text-light" href="#">FB</a>
                    <a class="text-light" href="#">IG</a>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <p>&copy; <?= date('Y') ?> MyOnlineShop. All rights reserved.</p>
    </div>
</footer>