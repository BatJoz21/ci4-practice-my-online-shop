<?= $this->extend("Layouts/layout") ?>

<?= $this->section("title") ?>Order <?= esc($order["order_number"] ?? "ORD-20000101-000000") ?><?= $this->endSection() ?>

<?= $this->section("main") ?>

    <?php if(!empty($order)): ?>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="mb-1">Order <?= esc($order["order_number"]) ?></h3>
                <p class="text-muted mb-0"><?= date('d M Y, H:i', strtotime($order["created_at"])) ?></p>
            </div>
            <a href="<?= base_url("merchant/orders") ?>" class="btn btn-outline-secondary btn-sm">
                &larr; Back to Orders
            </a>
        </div>

        <div class="row">
            <!-- customer, item, address -->
            <div class="col-lg-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Customer</h5>
                        <p class="mb-1"><strong><?= esc($order["owner_name"]) ?></strong></p>
                        <p class="text-muted mb-0"><?= esc($order["owner_name"]) ?></p>
                    </div>
                </div>

                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Items</h5>
                        <?php if(!empty($orderItems)): ?>
                            <?php foreach ($orderItems as $item): ?>
                                <div class="d-flex align-items-center gap-3 py-2 border-bottom">
                                    <div class="flex-grow-1">
                                        <p class="mb-0"><?= esc($item["product_name_snapshot"]) ?></p>
                                        <p class="text-muted small mb-0">
                                            <?= $item["quantity"] ?> &times; Rp<?= number_format($item["price_snapshot"], 0, ',', '.') ?>
                                        </p>
                                    </div>
                                    <div class="fw-bold">
                                        Rp<?= number_format($item["subtotal"], 0, ',', '.') ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                                <div class="d-flex align-items-center gap-3 py-2 border-bottom">
                                    <div class="flex-grow-1">
                                        <p class="mb-0">Shipping</p>
                                        <p class="text-muted small mb-0">
                                            <?= "1" ?> &times; Rp<?= number_format("50000", 0, ',', '.') ?>
                                        </p>
                                    </div>
                                    <div class="fw-bold">
                                        Rp<?= number_format("50000", 0, ',', '.') ?>
                                    </div>
                                </div>

                            <div class="d-flex justify-content-between fw-bold fs-5 pt-3">
                                <span>Total</span>
                                <span>Rp<?= number_format($order["total_amount"], 0, ',', '.') ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Status update -->
            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Order Status</h5>

                        <span class="badge bg-<?= $statusColors[$order["status"]] ?? "secondary" ?> fs-6 px-3 py-2 mb-3 d-inline-block">
                            <?= ucfirst($order["status"]) ?>
                        </span>

                        <?= form_open("merchant/orders/" . $order["id"]) ?>
                            <?= csrf_field() ?>
                            <input type="hidden" name="_method" value="PATCH">

                            <div class="mb-3">
                                <label for="status" class="form-label">Update Status</label>
                                <select name="status" id="status" class="form-select mb-3">
                                    <?php foreach (["pending", "paid", "shipped", "completed", "cancelled"] as $status): ?>
                                        <option value="<?= $status ?>" <?= $order["status"] === $status ? "selected" : "" ?>>
                                            <?= ucfirst($status) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="shipping_address" class="form-label">Shipping Address</label>
                                <textarea name="shipping_address" id="shipping_address"
                                    class="form-control" rows="4" required
                                ><?= old("shipping_address", $order["shipping_address"]) ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="estimated_arrival" class="form-label">Estimated Arrival</label>
                                <input type="date" name="estimated_arrival" id="estimated_arrival" class="form-control">
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                Save Changes
                            </button>
                        <?= form_close() ?>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <p>No data</p>
    <?php endif ?>

<?= $this->endSection() ?>