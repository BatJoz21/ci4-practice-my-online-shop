<?= $this->extend("Layouts/layout") ?>

<?= $this->section("title") ?>Payment Result<?= $this->endSection() ?>

<?= $this->section("main") ?>

    <div class="text-center py-5">
        <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
        <h3 class="mt-3 mb-2">Thank you!</h3>
        <p class="text-muted mb-4">
            We're confirming your payment now. This usually takes just a moment.
        </p>
        <a href="<?= base_url("orders/" . $orderID) ?>" class="btn btn-primary">View Order</a>
    </div>

<?= $this->endSection() ?>