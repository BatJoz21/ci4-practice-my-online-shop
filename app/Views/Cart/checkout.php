<?= $this->extend("Layouts/layout") ?>

<?= $this->section("title") ?>Checkout<?= $this->endSection() ?>

<?= $this->section("main") ?>
<?php 
    $cartTotal = 0;
?>

    <h3 class="mb-4">Checkout</h3>

        <?= form_open("orders") ?>
            <?= csrf_field() ?>

            <div class="row">
            <?php if(!empty($items)): ?>
                <!-- Left Side -->
                <div class="col-lg-8">
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Shipping Address</h5>
                            <textarea name="shipping_address" id="shipping_address" class="form-control" 
                                rows="4" placeholder="Full name, street address, city, postal code, phone number" 
                                required><?= old('shipping_address') ?></textarea>
                        <div class="form-text">This is where your order will be shipped.</div>
                        </div>
                    </div>

                    <!-- Order review -->
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Order Review</h5>

                            <?php foreach($items as $item): ?>
                                <div class="d-flex align-items-center gap-3 py-2 border-bottom">
                                    <img src="<?= site_url("products/" . $item["product_id"] . "/image") ?>" alt="<?= esc($item['product_name']) ?>"
                                        style="width: 60px; height: 60px; object-fit: cover;" class="rounded border">
                                    <div class="flex-grow-1">
                                        <p class="mb-0"><?= esc($item["product_name"]) ?></p>
                                        <?php if (!empty($item["variant_name"])): ?>
                                            <span class="badge bg-secondary"><?= esc($item["variant_name"]) ?></span>
                                        <?php endif; ?>
                                        <p class="text-muted small mb-0">
                                            <?= $item["quantity"] ?> &times; Rp<?= number_format($item["price_snapshot"], 0, ',', '.') ?>
                                        </p>
                                    </div>
                                    <div class="fw-bold">
                                        Rp<?= number_format($item["price_snapshot"] * $item["quantity"], 0, ',', '.') ?>
                                    </div>
                                </div>
                                <?php $cartTotal = $cartTotal + ($item["price_snapshot"] * $item["quantity"]) ?>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <!-- ToDo: no item page -->
            <?php 
                endif;
                $cartTotal += 50000;
            ?>

                <!-- Right Side -->
                <div class="col-lg-4">
                    <div class="card shadow sm">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Order Summary</h5>

                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Subtotal</span>
                                <span>Rp<?= number_format($cartTotal, 0, ',', '.') ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Shipping</span>
                                <span class="text-muted">Rp<?= number_format("50000", 0, ',', '.') ?></span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-4 fw-bold fs-5">
                                <span>Total</span>
                                <span>Rp<?= number_format($cartTotal, 0, ',', '.') ?></span>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                Place Order
                            </button>
                            <p class="text-muted small text-center mt-2 mb-0">
                                Payment will be arranged after order confirmation.
                            </p>
                        <a href="<?= base_url('cart') ?>" class="btn btn-link w-100 mt-2">
                            &larr; Back to Cart
                        </a>
                        </div>
                    </div>
                </div>
            </div>
        <?= form_close() ?>

<?= $this->endSection() ?>