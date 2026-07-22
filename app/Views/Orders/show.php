<?= $this->extend("Layouts/layout") ?>

<?= $this->section("title") ?>Order <?= esc($order["order_number"] ?? "ORD-00000101-000000") ?><?= $this->endSection() ?>

<?= $this->section("main") ?>

    <div>
        <?php if(!empty($order) && !empty($orderItems)): ?>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="mb-1">Order <?= esc($order["order_number"]) ?></h3>
                    <p class="text-muted mb-0"><?= date('d M Y, H:i', strtotime($order["created_at"])) ?></p>
                </div>
                <a href="<?= base_url("orders") ?>" class="btn btn-outline-secondary btn-sm">
                    &larr; Back to Orders
                </a>
            </div>

            <!-- Status -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <?php if($order["status"] === "cancelled"): ?>
                        <div class="text-center py-3">
                            <span class="badge bg-danger fs-6 px-3 py-2">Order Cancelled</span>
                        </div>
                    <?php else: ?>
                        <?php
                            $steps = ['pending', 'paid', 'shipped', 'completed'];
                            $currentIndex = array_search($order['status'], $steps);
                        ?>
                        <div class="d-flex justify-content-between position-relative">
                            <?php foreach($steps as $i => $step): ?>
                                <div class="text-center flex-fill position-relative">
                                    <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center
                                        <?= $i <= $currentIndex ? "bg-primary text-white" : "bg-light border text-muted" ?>"
                                        style="width: 36px; height: 36px;"
                                    >
                                        <?= $i < $currentIndex ? "&check;" : $i + 1 ?>    
                                    </div>
                                    <p class="small mt-2 mb-0 <?= $i <= $currentIndex ? "fw-bold" : "text-muted" ?>">
                                        <?= ucfirst($step) ?>
                                    </p>

                                    <?php if ($i < count($steps) - 1): ?>
                                        <div
                                            class="position-absolute top-0 <?= $i < $currentIndex ? "bg-primary" : "bg-light border-top" ?>"
                                            style="height: 3px; width: 100%; left: 50%; top: 17px; z-index: -1;"
                                        ></div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="row">
                <!-- Item + address -->
                <div class="col-lg-8">
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Items</h5>
                            <?php foreach($orderItems as $item): ?>
                                <div class="d-flex align-items-center gap-3 py-2 border-bottom">
                                    <div class="flex-grow-1">
                                        <p class="mb-0"><?= esc($item["product_name_snapshot"]) ?></p>
                                        <p class="text-muted small mb-0">
                                            <?= $item["quantity"] ?> &times; Rp<?= number_format($item["price_snapshot"], 0, ',', '.') ?>
                                        </p>

                                        <?php if($order["status"] === "completed"): ?>
                                            <?php $queryString = http_build_query(["order_id" => $order["id"]]); ?>
                                            <a href="<?= base_url("products/" . $item["product_id"] . "/reviews?" . $queryString) ?>" 
                                                class="btn btn-sm btn-outline-primary mt-2">
                                                Leave a Review
                                            </a>
                                        <?php endif; ?>
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
                        </div>
                    </div>

                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-2">Shipping Address</h5>
                            <p class="mb-0"><?= nl2br(esc($order["shipping_address"])) ?></p>
                        </div>
                    </div>
                </div>

                <!-- Summary + Actions -->
                <div class="col-lg-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Total</h5>
                            <div class="d-flex justify-content-between fw-bold fs-5 mb-3">
                                <span>Total</span>
                                <span>Rp<?= number_format($order["total_amount"], 0, ',', '.') ?></span>
                            </div>
                        </div>

                        <?php if ($order["status"] === "pending"): ?>
                            <div class="text-center">
                                <?= form_open("orders/" . $order["id"] . "/payment") ?>
                                    <?= csrf_field() ?>
                                    <button
                                        type="submit"
                                        class="btn btn-primary w-50 mb-2"
                                    >
                                        Pay Now
                                    </button>
                                <?= form_close() ?>

                                <?= form_open("orders/" . $order["id"] . "/cancel") ?>
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="_method" value="PATCH">
                                    
                                    <button
                                        type="submit"
                                        class="btn btn-outline-danger w-50"
                                        onclick="return confirm('Cancel this order?');"
                                    >
                                        Cancel Order
                                    </button>
                                <?= form_close() ?>
                            </div>
                        <?php elseif($order["status"] === "shipped"): ?>
                            <div class="text-center">
                                <?= form_open("orders/" . $order["id"] . "/complete") ?>
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="_method" value="PATCH">

                                    <button
                                        type="submit"
                                        class="btn btn-success w-50 mb-2"
                                        onclick="return confirm('Complete this order?\nMake sure you have received the packages');"
                                    >
                                        Complete order
                                    </button>
                                <?= form_close() ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <p></p>
        <?php endif; ?>
    </div>

<?= $this->endSection() ?>