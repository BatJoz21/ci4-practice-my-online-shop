<?= $this->extend("Layouts/layout") ?>

<?= $this->section("title") ?>Home<?= $this->endSection() ?>

<?= $this->section("main") ?>

    <div class="container">
        <h1 class="text-center">Hello! Welcome to MyOnlineShop!</h1>
    </div>

    <!-- Hero card -->
    <div 
        class="rounded-3 text-white d-flex flex-column justify-content-center align-items-center text-center mb-5"
        style="
            background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url(<?= base_url("images/hero_card.jpg") ?>) center/cover;
            min-height: 320px;
            padding: 2rem;
        ">
        <h1 class="display-5 fw-bold mb-3">Shop the Lateste Arrivals</h1>
        <p class="fs-5 mb-4">Quality products, straight to your door.</p>
        <a href="<?= base_url("products") ?>" class="btn btn-primary btn-lg">Shop Now</a>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">New Arrivals</h3>
        <a href="<?= base_url("products") ?>" class="text-decoration-none">View All &rarr;</a>
    </div>

    <?php if(!empty($products)): ?>
        <div class="row row-cols-2 row-cols-md-4 g-4">
            <?php foreach($products as $product): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <img src="<?= site_url("products/" . $product["id"] . "/image") ?>" class="card-img-top" alt="<?= esc($product["name"]) ?>" 
                            class="card-img-top" alt="<?= esc($product["name"]) ?>"
                            style="height: 180px; object-fit:cover;">
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title"><?= esc($product["name"]) ?></h6>
                            <p class="card-text fw-bold mb-2">
                                Rp<?= number_format($product["price"], 0, ",", ".") ?>
                            </p>
                            <a href="<?= base_url("products/" . $product["id"]) ?>" class="btn btn-outline-secondary btn-sm mt-auto">View Product</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-center text-muted mt-4">No products yet.</p>
    <?php endif; ?>

<?= $this->endSection() ?>