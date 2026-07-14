<?= $this->extend("Layouts/layout") ?>

<?= $this->section("title") ?>Your Cart<?= $this->endSection() ?>

<?= $this->section("main") ?>
<?php 
    $cartTotal = 0;
?>

    <h3 class="mb-4">My Cart</h3>
    <?php $cartTotal = 0; ?>

    <?php if(!empty($items)): ?>
        <div class="row">
            <!-- Cart Items -->
            <div class="col-lg-8">
                <?php foreach($items as $item): ?>
                    <div class="card mb-3 shadow-sm">
                        <div class="card-body">
                            <div class="row align-items-center g-3">
                                <div class="col-auto">
                                    <img src="<?= site_url("products/" . $item["product_id"] . "/image") ?>" 
                                        alt="" style="width: 90px; height: 90px; object-fit: cover;"
                                        class="rounded border">
                                </div>

                                <div class="col-auto">
                                    <?= form_open("cart/" . $item["id"]) ?>
                                        <?= csrf_field() ?>

                                        <div class="input-group input-group-sm">
                                            <input type="hidden" name="_method" value="PATCH">

                                            <input type="hidden" name="variant_id" value="<?= esc($item["variant_id"]) ?>">
                                            <input type="hidden" name="price" value="<?= esc($item["price_snapshot"]) ?>">
                                            <input type="number" name="quantity" value="<?= $item["quantity"] ?>"
                                                min="1" class="form-control">
                                            <button type="submit" class="btn btn-outline-primary">Update</button>
                                        </div>
                                    <?= form_close() ?>
                                </div>

                                <div class="col-auto text-end" style="min-width: 130px;">
                                    <p class="fw-bold mb-1">
                                        Rp<?= number_format($item['price_snapshot'], 0, ',', '.') ?>
                                    </p>
                                    <?= form_open("cart/" . $item["id"]) ?>
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-sm btn-link text-danger p-0">
                                            Remove
                                        </button>
                                    <?= form_close() ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $cartTotal = $cartTotal + $item["price_snapshot"] ?>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="col-g-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">Order Summary</h5>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal</span>
                        <span>Rp<?= number_format($cartTotal, 0, ',', '.') ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Shipping</span>
                        <span class="text-muted">Calculated at checkout</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-3 fw-bold fs-5">
                        <span>Total</span>
                        <span>Rp<?= number_format($cartTotal, 0, ',', '.') ?></span>
                    </div>

                    <a href="<?= base_url("cart/checkout") ?>" class="btn btn-primary w-100">
                        Proceed to Checkout
                    </a>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="text-center py-5">
            <p class="text-muted fs-5">Your cart is empty.</p>
            <a href="<?= base_url('products') ?>" class="btn btn-primary">Browse Products</a>
        </div>
    <?php endif; ?>

<?= $this->endSection() ?>