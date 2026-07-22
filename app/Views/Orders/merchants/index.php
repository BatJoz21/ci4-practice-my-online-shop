<?= $this->extend("Layouts/layout") ?>

<?= $this->section("title") ?>All Orders<?= $this->endSection() ?>

<?= $this->section("main") ?>

<?php 
    $statusColor = [
        "pending"       => "secondary",
        "paid"          => "info",
        "shipped"       => "warning",
        "completed"     => "success",
        "cancelled"     => "danger"
    ];
    $statuses = ["all", "pending", "paid", "shipped", "completed", "cancelled"];

    $categories = [
        "Order Number"      => "order-number",
        "Total Amount"      => "total-amount",
        "Customer Name"     => "name"
    ];
?>

    <h3>Orders</h3>

    <!-- Search bar -->
    <?= form_open("merchant/orders", ["method" => "get"]) ?>
        <div class="row g-2 mb-3">
            <div class="col-md-3">
                <select name="filter" id="filter" class="form-select">
                    <?php foreach($categories as $i => $val): ?>
                        <option value="<?= $val ?>" <?= ($currentFilter === $val) ? "selected" : "" ?>><?= $i ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-5">
                <input type="text" name="search" class="form-control" placeholder="Enter you input here...">
            </div>

            <div class="col-auto">
                <button type="submit" class="btn btn-outline-secondary">Search</button>
            </div>
        </div>
    <?= form_close() ?>

    <!-- Status Tabs -->
    <div class="nav nav-tabs mb-4">
        <?php foreach($statuses as $status): ?>
            <li class="nav-item">
                <a href="<?= base_url("merchant/orders?status=" . $status) ?>" class="nav-link <?= $currentStatus === $status ? 'active' : '' ?>">
                    <?= ucfirst($status) ?>
                </a>
            </li>
        <?php endforeach; ?>
    </div>

    <?php if(!empty($orders)): ?>
        <?php foreach($orders as $order): ?>
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center g-3">
                        <div class="col-md-2">
                            <p class="mb-1 text-muted small">Order Number</p>
                            <p class="mb-0 fw-bold"><?= esc($order["order_number"]) ?></p>
                        </div>

                        <div class="col-md-2">
                            <p class="mb-1 text-muted small">Create Date</p>
                            <p class="mb-0"><?= date('d M Y', strtotime($order["created_at"])) ?></p>
                        </div>

                        <div class="col-md-2">
                            <p class="mb-1 text-muted small">Estimated Arrival Date</p>
                            <?php if(!empty($order["estimated_arrival"])): ?>
                                <p class="mb-0"><?= date('d M Y', strtotime($order["estimated_arrival"])) ?></p>
                            <?php else: ?>
                                <p class="mb-0">-</p>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-2">
                            <p class="mb-1 text-muted small">Status</p>
                            <span class="badge bg-<?= $statusColor[$order["status"] ?? "secondary"] ?>">
                                <?= ucfirst($order["status"]) ?>
                            </span>
                        </div>

                        <div class="col-md-2">
                            <p class="mb-1 text-muted small">Customer</p>
                            <p class="mb-0 fw-bold">
                                <?= esc($order["owner_name"]) ?>
                            </p>
                        </div>

                        <div class="col-md-2 text-md-end">
                            <a href="<?= base_url("merchant/orders/" . $order["id"]) ?>" class="btn btn-outline-primary btn-sm">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <!-- Pagination -->
        <nav class="mt-5">
            <ul class="pagination justify-content-center">
                <?php for($i = 1; $i <= ($totalPages ?? 1); $i++): ?>
                    <li class="page-item <?= ($i == ($currentPage ?? 1)) ? "active" : "" ?>">
                        <?php if($currentStatus != "all"): ?>
                            <a href="<?= base_url("merchant/orders?page=" . $i . "&status=" . $currentStatus) ?>" class="page-link"><?= $i ?></a>
                        <?php else: ?>
                            <a href="<?= base_url("merchant/orders?page=" . $i) ?>" class="page-link"><?= $i ?></a>
                        <?php endif; ?>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    <?php else: ?>
        <div class="text-center py-5">
            <p class="text-muted fs-5">No orders found.</p>
        </div>
    <?php endif; ?>

<?= $this->endSection() ?>