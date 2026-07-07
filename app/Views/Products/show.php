<?= $this->extend("Layouts/layout") ?>

<?= $this->section("title") ?><?= esc($product["name"] ?? "Show Product") ?><?= $this->endSection() ?>

<?= $this->section("main") ?>

    <div class="row g-4">
    <?php if(!empty($product)): ?>
        <!-- Image -->
        <div class="col-md-5">
            <img src="<?= site_url("products/" . $product["id"] . "/image") ?>" 
                class="img-fluid rounded-3 border" alt="<?= esc($product["name"]) ?>">
        </div>

        <!-- Details -->
        <div class="col-md-7">
            <span class="badge bg-secondary mb-2"><?= esc($product["category_name"] ?? "") ?></span>
            <h2><?= esc($product["name"]) ?></h2>

            <p class="fs-3 fw-bold text-primary" id="displayPrice">
                Rp<?= number_format($product['price'], 0, ',', '.') ?>
            </p>

            <p class="text-muted"><?= esc($product["description"]) ?></p>

            <?= form_open("#") ?>
                <input type="hidden" name="product_id" value="<?= esc($product["id"]) ?>">

                <?php if(!empty($variants)): ?>
                <?php endif; ?>

                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="number" name="quantity" id="quantity" class="form-control" 
                        value="1" min="1" style="max-width: 120px;">
                </div>

                <button type="submit" class="btn btn-primary btn-lg" id="addToCartBtn">Add to cart</button>
            <?= form_close() ?>
        </div>
    <?php endif; ?>
    </div>

    <!-- Reviews -->
    <hr class="my-5">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <h4 class="mb-4">
                Reviews
                <span class="text-muted fs-6"><?= count($reviews ?? []) ?></span>
            </h4>

            <?php if(empty($reviews)): ?>
                <p class="text-muted">No reviews yet.</p>
            <?php else: ?>
                <?php foreach($reviews as $review): ?>
                    <div class="border-bottom pb-3 mb-3">
                        <div class="d-flex justify-content-between">
                            <!-- ToDo: review UI -->
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

<?= $this->endSection() ?>