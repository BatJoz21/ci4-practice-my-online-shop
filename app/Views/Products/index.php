<?= $this->extend("Layouts/layout") ?>

<?= $this->section("title") ?>Products<?= $this->endSection() ?>

<?= $this->section("main") ?>

    <!-- Filter Bar -->
    <div class="bg-light border rounded-3 p-3 mb-4">
        <?= form_open("products") ?>
            <input type="hidden" name="_method" value="GET">
            <div class="row g-2 align-items-center">
                <div class="col-md-7">
                    <input type="text" name="search" class="form-control" placeholder="Search product..." value="<?= esc($search ?? "") ?>">
                </div>

                <div class="col-md-3">
                    <select name="category_id" id="category_id" class="form-select">
                        <option value="">All Categories</option>
                        <?php if(!empty($categories)): ?>
                            <?php foreach($categories as $category): ?>
                                <option value="<?= $category["id"] ?>"><?= esc($category["name"]) ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Product Grid -->
    <?php if(!empty($products)): ?>
        <div class="row row-cols-2 row-cols-md-4 g-4">
            <?php foreach($products as $product): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <img src="<?= site_url("products/" . $product["id"] . "/image") ?>" class="card-img-top" alt="<?= esc($product["name"]) ?>" style="height: 180px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title"><?= esc($product["name"]) ?></h6>
                            <p class="card-text fw-bold mb-2">
                                Rp<?= number_format($product["price"], 0, ",", ".") ?>
                            </p>

                            <div class="mt-auto d-grid gap-2">
                                <a href="products/<?= esc($product["id"]) ?>" class="btn btn-outline-primary btn-sm">View</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-center text-muted mt-5">No products found.</p>
    <?php endif; ?>

    <!-- Pagination -->
    <nav class="mt-5">
        <ul class="pagination justify-content-center">
            <?php for($i = 1; $i <= ($totalPages ?? 1); $i++): ?>
                <li class="page-item <?= ($i == ($currentPage ?? 1)) ? 'active' : '' ?>">
                    <a href="#" class="page-link"><?= $i ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>

<?= $this->endSection() ?>