<?= $this->extend("Layouts/layout") ?>

<?= $this->section("title") ?>Login<?= $this->endSection() ?>

<?= $this->section("main") ?>

    <div class="container">
        <h2 class="text-center my-4">Login</h2>
        <div class="border rounded-3 shadow mx-auto p-4" style="max-width: 500px;">
            <?= form_open("login") ?>
                <div class="mb-3 row">
                    <label for="email" class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="email" id="email">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="password" class="col-sm-3 col-form-label">Password</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" name="password" id="password">
                        <span id="passwordHelpInline" class="form-text">Must be 8-20 characters long.</span>
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            <?= form_close() ?>
        </div>
    </div>

<?= $this->endSection() ?>