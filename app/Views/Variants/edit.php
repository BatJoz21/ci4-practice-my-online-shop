<?= $this->extend("Layouts/layout") ?>

<?= $this->section("title") ?>Edit Variant<?= $this->endSection() ?>

<?= $this->section("main") ?>

    <div class="d-flex justify-content-center align-items-center">
        <!-- Edit variant -->
        <div class="border rounded-3 shadow-sm p-4" style="max-width: 600px;">
            <h6 class="mb-3">Add Variant</h6>
            <?= form_open("merchant/products/" . $id . "/variants/" . $variant["id"]) ?>
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PATCH">
                
                <div class="mb-3">
                    <label for="name" class="form-label">Size</label>
                    <input type="text" name="name" id="name" class="form-control" value="<?= esc($variant["name"] ?? old("name")) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="sku" class="form-label">SKU</label>
                    <input type="text" name="sku" id="sku" class="form-control" value="<?= esc($variant["sku"] ?? old("sku")) ?>" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="price_modifier" class="form-label">Price Modifier (Rp)</label>
                        <input type="number" name="price_modifier" id="price_modifier"
                            class="form-control" value="<?= esc($variant["price_modifier"] ?? old("price_modifier", 0)) ?>" step="0.01"
                        >
                        <div class="form-text">Added to base price. Use negative for a discount.</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="stock" class="form-label">Stock</label>
                        <input type="number" name="stock" id="stock"
                            class="form-control" value="<?= esc($variant["stock"] ?? old("stock", 0)) ?>" min="0" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Edit Variant</button>
            <?= form_close() ?>
        </div>
    </div>

<?= $this->endSection() ?>