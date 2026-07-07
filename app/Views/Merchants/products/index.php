<?= $this->extend("Layouts/layout") ?>

<?= $this->section("title") ?>My Products<?= $this->endSection() ?>

<?= $this->section("main") ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">My Products</h3>
        <a href="<?= base_url("products/new") ?>" class="btn btn-primary">+ Create New Product</a>
    </div>

    <!-- Search bar -->
    <?= form_open("#") ?>
        <div class="row g-2 mb-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search your products...">
            </div>

            <div class="col-auto">
                <button type="submit" class="btn btn-outline-secondary">Search</button>
            </div>
        </div>
    <?= form_close() ?>

    <?php if(!empty($products)): ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th class="text-center">Variants</th>
                        <th class="text-center">Edit</th>
                        <th class="text-center">Delete</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($products as $product): ?>
                        <tr>
                            <td><?= esc($product["name"]) ?></td>
                            <td>
                                <span class="badge bg-secondary"><?= esc($product["category_name"]) ?></span>
                            </td>
                            <td class="text-center">
                                <a href="#" class="btn btn-sm btn-outline-info">Show</a>
                            </td>
                            <td class="text-center">
                                <a href="#" class="btn btn-sm btn-outline-primary">Edit</a>
                            </td>
                            <td class="text-center">
                                <?= form_open("#") ?>
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                <?= form_close() ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="text-center text-muted mt-4">You haven't added any products yet.</p>
    <?php endif; ?>

<?= $this->endSection() ?>