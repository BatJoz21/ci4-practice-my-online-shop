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

    <!-- Filter Bar -->
    <div class="bg-light border rounded-3 p-3 mb-4">
        <?= form_open("admin/users", ["method" => "get"]) ?>
            <div class="row g-2 align-items-center">
                <div class="col-md-7">
                    <input type="text" name="search" class="form-control" placeholder="Search user..." value="<?= esc($search ?? "") ?>">
                </div>

                <div class="col-md-3">
                    <select name="role" id="role" class="form-select">
                        <option value="">All Role</option>
                            <?php foreach($roleColors as $role => $color): ?>
                                <option value="<?= $role ?>" 
                                    <?= (!empty($selectedRole) && $selectedRole == $role) ? "selected" : "" ?>>
                                    <?= esc($role) ?>
                                </option>
                            <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </div>
        </form>
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

        <!-- Pagination -->
        <nav class="mt-5">
            <ul class="pagination justify-content-center">
                <?php for($i = 1; $i <= ($totalPages ?? 1); $i++): ?>
                    <li class="page-item <?= ($i == ($currentPage ?? 1)) ? "active" : "" ?>">
                        <?php if(!empty($selectedRole)): ?>
                            <a href="<?= base_url("admin/users?page=" . $i . "&role=" . $selectedRole) ?>" class="page-link"><?= $i ?></a>
                        <?php else: ?>
                            <a href="<?= base_url("admin/users?page=" . $i) ?>" class="page-link"><?= $i ?></a>
                        <?php endif; ?>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    <?php endif; ?>

<?= $this->endSection() ?>