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
        <h3 class="mb-0">Users</h3>
    </div>

    <?php if(!empty($users)): ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Joined at</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($users as $user): ?>
                        <tr>
                            <td><?= esc($user["name"]) ?></td>
                            <td><?= esc($user["email"]) ?></td>
                            <td>
                                <span class="badge bg-<?= $roleColors[$user["role"]] ?>"><?= esc($user["role"]) ?></span>
                            </td>
                            <td><?= date("d M Y", strtotime($user["created_at"])) ?></td>
                            <td><a href="<?= base_url("admin/users/" . $user["id"]) ?>" class="btn btn-outline-info btn-sm">View</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

<?= $this->endSection() ?>