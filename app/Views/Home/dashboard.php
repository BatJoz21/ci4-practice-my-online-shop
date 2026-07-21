<?= $this->extend("Layouts/layout") ?>

<?= $this->section("title") ?>Dashboard<?= $this->endSection() ?>

<?= $this->section("main") ?>

    <h3 class="mb-4">Dashboard</h3>

    <!-- Summary Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted small mb-1">Total Products</p>
                    <h3 class="mb-0"><?= $stats["total_products"] ?? "0" ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted small mb-1">Pending Orders</p>
                    <h3 class="mb-0"><?= $stats["pending_orders"] ?? "0" ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted small mb-1">Total Revenue</p>
                    <h3 class="mb-0">Rp <?= number_format($stats["total_revenue"] ?? "0", 0, ",", ".") ?></h3>
                    <p class="text-muted small mb-0">From completed orders</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm h-100 <?= ($stats["low_stock_count"] ?? 0) > 0 ? "border-warning" : "" ?>">
                <div class="card-body">
                    <p class="text-muted small mb-1">Low Stock Item</p>
                    <h3 class="mb-0 <?= ($stats["low_stock_count"] ?? 0) > 0 ? "text-warning" : "" ?>"><?= $stats["low_stock_count"] ?? "0" ?></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Recent orders -->
        <div class="col-lg-7">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">Recent Orders</h5>
                        <a href="<?= base_url("merchant/orders") ?>" class="text-decoration-none small">
                            View All &rarr;
                        </a>
                    </div>

                    <?php if(!empty($recentOrders)): ?>
                        <div class="table-responsive">
                            <table class="table table-sm align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Order</th>
                                        <th>Status</th>
                                        <th class="text-end">Total</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach($recentOrders as $order): ?>
                                        <tr>
                                            <td>
                                                <a href="<?= base_url("merchant/orders/" . $order["id"]) ?>" class="text-decoration-none">
                                                    <?= esc($order["order_number"]) ?>
                                                </a>
                                            </td>
                                            <td>
                                                <span class="badge bg-<?= $statusColors[$order["status"]] ?? "secondary" ?>">
                                                    <?= ucfirst($order["status"]) ?>
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                Rp<?= number_format($order["total_amount"], 0, ",", ".") ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-muted mb-0">No orders yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Low stock, recent review -->
        <div class="col-lg-5">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">Low Stock</h5>

                    <?php if(!empty($lowStockItems)): ?>
                        <?php foreach($lowStockItems as $item): ?>
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                <div>
                                    <p class="mb-0"><?= esc($item["product_name"]) ?></p>
                                    <?php if (!empty($item["variant_name"])): ?>
                                        <span class="badge bg-secondary">Size <?= esc($item["variant_name"]) ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-muted mb-0">All products are well stocked.</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">Recent Reviews</h5>

                    <?php if(!empty($reviews)): ?>
                        <?php foreach($reviews as $review): ?>
                            <div class="py-2 border-bottom">
                                <div class="d-flex justify-content-between">
                                    <span class="small fw-bold"><?= esc($review["product_name"]) ?></span>
                                    <span class="text-warning small">
                                        <?= str_repeat("★", $review["rating"]) . str_repeat("☆", 5 - $review["rating"]) ?>
                                    </span>
                                </div>
                                <p class="text-muted small mb-0"><?= esc($review["comment"]) ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-muted mb-0">No reviews yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

<?= $this->endSection() ?>