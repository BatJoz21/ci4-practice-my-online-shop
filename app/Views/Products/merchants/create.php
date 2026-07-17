<?= $this->extend("Layouts/layout") ?>

<?= $this->section("title") ?>New Product<?= $this->endSection() ?>

<?= $this->section("main") ?>

    <h3 class="mb-4">Create New Product</h3>

    <div class="border rounded-3 shadow-sm p-4" style="max-width: 700px;">
        <?= form_open_multipart("merchant/products") ?>
            <div class="mb-3">
                <label for="name" class="form-label">Product Name</label>
                <input type="text" name="name" id="name" class="form-control" value="<?= old("name") ?>" required>
            </div>

            <div class="mb-3">
                <label for="slug" class="form-label">Product Slug</label>
                <input type="text" name="slug" id="slug" class="form-control" value="<?= old("slug") ?>" required>
            </div>

            <div class="mb-3">
                <label for="category_id" class="form-label">Category</label>
                <select name="category_id" id="category_id" class="form-select" required>
                    <option value="" disabled selected>Select a category</option>
                    <?php foreach($categories as $category): ?>
                        <option value="<?= $category["id"] ?>" <?= (old("category_id") == $category["id"]) ? "selected" : "" ?>>
                            <?= esc($category["name"]) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control" rows="4"><?= old("description") ?></textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="price" class="form-label">Price (Rp)</label>
                    <input type="number" name="price" id="price" class="form-control" 
                        value="<?= old("price") ?>" min="1000" step="1000" required>
                </div>
            </div>

            <div class="mb-4">
                <label for="image" class="form-label">Product Image</label>
                <input type="file" name="image" id="image" class="form-control">
                <div class="form-text">JPG or PNG, max 10MB.</div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Create Product</button>
                <a href="<?= base_url("merchant/products") ?>" class="btn btn-outline-secondary">Cancel</a>
            </div>
        <?= form_close() ?>
    </div>

<?= $this->endSection() ?>