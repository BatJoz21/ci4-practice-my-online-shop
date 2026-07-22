<?= $this->extend("Layouts/layout") ?>

<?= $this->section("title") ?>Create Review<?= $this->endSection() ?>

<?= $this->section("main") ?>

    <h3 class="mb-4">Write a Review</h3>
    <?php if(!empty($product) && !empty($orderID)): ?>
        <div class="card shadow-sm mx-auto" style="max-width: 600px;">
            <div class="card-body">
                <!-- Product context -->
                <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom">
                    <img
                        src="<?= site_url("products/" . $product["id"] . "/image") ?>"
                        alt="<?= esc($product["name"]) ?>"
                        style="width: 64px; height: 64px; object-fit: cover;"
                        class="rounded border"
                    >
                    <h5 class="mb-0"><?= esc($product["name"]) ?></h5>
                </div>

                <?= form_open("products/" . $product["id"] . "/reviews") ?>
                    <?= csrf_field() ?>
                    <input type="hidden" name="order_id" value="<?= esc($orderID) ?>">

                    <div class="mb-4">
                        <label class="form-label d-block">Your Rating</label>
                        <div class="star-rating">
                            <input type="radio" name="rating" id="star5" value="5" required>
                            <label for="star5"><i class="bi bi-star-fill"></i></label>

                            <input type="radio" name="rating" id="star4" value="4">
                            <label for="star4"><i class="bi bi-star-fill"></i></label>

                            <input type="radio" name="rating" id="star3" value="3">
                            <label for="star3"><i class="bi bi-star-fill"></i></label>

                            <input type="radio" name="rating" id="star2" value="2">
                            <label for="star2"><i class="bi bi-star-fill"></i></label>

                            <input type="radio" name="rating" id="star1" value="1">
                            <label for="star1"><i class="bi bi-star-fill"></i></label>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="comment" class="form-label">Your Review</label>
                        <textarea
                            name="comment"
                            id="comment"
                            class="form-control"
                            rows="4"
                            placeholder="Share your experience with this product..."
                        ><?= old('comment') ?></textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Submit Review</button>
                        <a href="<?= base_url("orders") ?>" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                <?= form_close() ?>
            </div>
        </div>
    <?php else: ?>
        <p>No product can be reviewed.</p>
    <?php endif; ?>

<?= $this->endSection() ?>