<?= $this->extend("Layouts/layout") ?>

<?= $this->section("title") ?>My Products<?= $this->endSection() ?>

<?= $this->section("main") ?>

<?php 
    $roleColors = [
        "customer"       => "secondary",
        "merchant"       => "info",
        "superadmin"     => "success",
    ];
?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Profile</h3>
    </div>

    <?php if(!empty($profile)): ?>
        <dl class="row">
            <dt class="col-sm-3">Name</dt>
            <dd class="col-sm-9"><?= esc($profile["name"]) ?></dd>

            <dt class="col-sm-3">Email</dt>
            <dd class="col-sm-9"><?= esc($profile["email"]) ?></dd>

            <dt class="col-sm-3">Role</dt>
            <dd class="col-sm-9">
                <span class="badge bg-<?= $roleColors[$profile["role"]] ?> mb-2"><?= esc($profile["role"]) ?></span>
            </dd>

            <dt class="col-sm-3">Joined at</dt>
            <dd class="col-sm-9"><?= date("d M Y", strtotime($profile["created_at"])) ?></dd>
        </dl>
    <?php endif; ?>

<?= $this->endSection() ?>