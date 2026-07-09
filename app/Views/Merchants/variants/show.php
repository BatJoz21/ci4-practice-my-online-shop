<?= $this->extend("Layouts/layout") ?>

<?= $this->section("title") ?>Manage Variants<?= $this->endSection() ?>

<?= $this->section("main") ?>

    <?php if(!empty($product)): ?>
        <!-- Product Information -->
        <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom">
            <img src="<?= site_url("products/" . $product["id"] . "/image") ?>" alt="<?= esc($product['name']) ?>"
                style="width: 64px; height: 64px; object-fit: cover;" class="rounded border">
            <div>
                <h4 class="mb-0"><?= esc($product["name"]) ?></h4>
                <span class="text-muted">Base price: Rp<?= number_format($product['price'], 0, ',', '.') ?></span>
            </div>
            <a href="<?= base_url("my-products") ?>" class="btn btn-outline-secondary btn-sm ms-auto">
                &larr; Back to Products
            </a>
        </div>

        <h5 class="mb-3">Variants</h5>

        <div class="table-responsive mb-4">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Size</th>
                        <th>SKU</th>
                        <th class="text-end">Price Modifier</th>
                        <th class="text-end">Stock</th>
                        <th class="text-center">Edit</th>
                        <th class="text-center">Delete</th>
                    </tr>
                </thead>
                <tbody>
                <?php if(!empty($variants)): ?>
                    <?php foreach($variants as $variant): ?>
                        <tr>
                            <td><?= esc($variant["name"]) ?></td>
                            <td><code><?= esc($variant["sku"]) ?></code></td>
                            <td class="text-end">
                                <?= $variant["price_modifier"] >= 0 ? '+' : '' ?>Rp<?= number_format($variant["price_modifier"], 0, ',', '.') ?>
                            </td>
                            <td class="text-end">
                                <?php if ($variant['stock'] <= 0): ?>
                                    <span class="badge bg-danger">Out of stock</span>
                                <?php else: ?>
                                    <?= $variant['stock'] ?>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <a href="<?= base_url("my-products/" . $product["id"] . "/variants/" . $variant["id"] . "/edit") ?>" 
                                    class="btn btn-sm btn-outline-primary">Edit</a>
                            </td>
                            <td class="text-center">
                                <?= form_open("my-products/" . $product["id"] . "/variants/" . $variant["id"]) ?>
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button
                                        type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this variant?');">
                                        Delete
                                    </button>
                                <?= form_close() ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-3">
                            No variants yet. Add one below.
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Add new variant -->
        <div class="border rounded-3 shadow-sm p-4" style="max-width: 600px;">
            <h6 class="mb-3">Add Variant</h6>
            <?= form_open("my-products/" . $product["id"] . "/variants") ?>
                <?= csrf_field() ?>
                
                <div class="mb-3">
                    <label for="name" class="form-label">Size</label>
                    <input type="text" name="name" id="name" class="form-control" value="<?= old("name") ?>" required>
                </div>

                <div class="mb-3">
                    <label for="sku" class="form-label">SKU</label>
                    <input type="text" name="sku" id="sku" class="form-control" value="<?= old("sku") ?>" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="price_modifier" class="form-label">Price Modifier (Rp)</label>
                        <input type="number" name="price_modifier" id="price_modifier"
                            class="form-control" value="<?= old("price_modifier", 0) ?>" step="0.01"
                        >
                        <div class="form-text">Added to base price. Use negative for a discount.</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="stock" class="form-label">Stock</label>
                        <input type="number" name="stock" id="stock"
                            class="form-control" value="<?= old("stock", 0) ?>" min="0" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Add Variant</button>
            <?= form_close() ?>
        </div>
    <?php endif; ?>

<?= $this->endSection() ?>