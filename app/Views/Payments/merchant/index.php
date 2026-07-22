<?= $this->extend("Layouts/layout") ?>

<?= $this->section("title") ?>Payments<?= $this->endSection() ?>

<?= $this->section("main") ?>

<?php 
    $paymentStatusColors = [
        "pending"       => "warning",
        "success"       => "success",
        "failed"        => "danger",
        "expired"       => "secondary"
    ];

    $newDirection = "DESC";
    if(!empty($direction) && $direction === "DESC") {
        $newDirection = "ASC";
    }
?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Payments</h3>
    </div>

    <div class="bg-light border rounded-3 p-3 mb-4">
        <?= form_open("merchant/payments", ["method" => "get"]) ?>
            <div class="row g-2 align-items-center">
                <div class="col-md-10">
                    <input type="text" name="ord-num" class="form-control" placeholder="Search order number..." value="<?= esc($search ?? "") ?>">
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Search</button>
                </div>
            </div>
        </form>
    </div>

    <?php if(!empty($payments)): ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Order Number</th>
                        <th>Provider</th>
                        <th>Transaction ID</th>
                        <th>Status</th>
                        <th>
                            <a href="<?= base_url("/merchant/payments?order=amount&direction=" . $newDirection) ?>">
                                Amount<?= ($newDirection === "ASC") ? "&uarr;" : "&darr;" ?>
                            </a>
                        </th>
                        <th><a href="<?= base_url("/merchant/payments?order=paid_at&direction=" . $newDirection) ?>">
                            Paid At<?= ($newDirection === "ASC") ? "&uarr;" : "&darr;" ?>
                            </a>
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($payments as $payment): ?>
                        <tr>
                            <td><?= esc($payment["order_number"]) ?></td>
                            <td><?= esc($payment["provider"]) ?></td>
                            <td><?= esc($payment["transaction_id"]) ?></td>
                            <td>
                                <span class="badge bg-<?= $paymentStatusColors[$payment["status"]] ?>"><?= esc($payment["status"]) ?></span>
                            </td>
                            <td><?= esc($payment["amount"]) ?></td>
                            <td><?= date("d M Y", strtotime($payment["paid_at"])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <nav class="mt-5">
            <?= $pager->links('default', 'custom_pager') ?>
        </nav>
    <?php else: ?>
        <p class="text-center text-muted mt-4">No payment data.</p>
    <?php endif ?>

<?= $this->endSection() ?>