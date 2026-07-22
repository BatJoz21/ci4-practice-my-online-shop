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
        <h3 class="mb-0">User Data</h3>
    </div>

    <?php if(!empty($user)): ?>
        <dl class="row">
            <dt class="col-sm-3">Name</dt>
            <dd class="col-sm-9"><?= esc($user["name"]) ?></dd>

            <dt class="col-sm-3">Email</dt>
            <dd class="col-sm-9"><?= esc($user["email"]) ?></dd>

            <dt class="col-sm-3">Role</dt>
            <dd class="col-sm-9">
                <span class="badge bg-<?= $roleColors[$user["role"]] ?> mb-2"><?= esc($user["role"]) ?></span>
                <?= form_open("admin/users/" . $user["id"] . "/role") ?>
                    <input type="hidden" name="_method" value="PATCH">
                    <select name="role" id="role" class="form-select">
                        <option value="" disabled selected>Select a role to assign</option>
                        <?php foreach($roleColors as $role => $color): ?>
                            <option value="<?= $role ?>">
                                <?= $role ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <button type="submit" class="btn btn-primary btn-sm mt-2">Change Role</button>
                <?= form_close() ?>
            </dd>

            <dt class="col-sm-3">Joined at</dt>
            <dd class="col-sm-9"><?= date("d M Y", strtotime($user["created_at"])) ?></dd>
        </dl>
    <?php endif; ?>

<?= $this->endSection() ?>