<?= $this->extend("Layouts/layout") ?>

<?= $this->section("title") ?>Register<?= $this->endSection() ?>

<?= $this->section("main") ?>

    <div class="container">
        <h2 class="text-center my-4">User Registration</h2>
        <div class="border rounded-3 shadow mx-auto p-4" style="width: 500px;">
            <?= form_open("register") ?>
                <div class="mb-3 row" style="width: 400px;">
                    <label for="full_name" class="col-sm-3 col-form-label">Full Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="full_name" id="full_name">
                    </div>
                </div>

                <div class="mb-3 row" style="width: 400px;">
                    <label for="nickname" class="col-sm-3 col-form-label">Nickname</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="nickname" id="nickname">
                    </div>
                </div>

                <div class="mb-3 row" style="width: 400px;">
                    <label for="email" class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="email" id="email">
                    </div>
                </div>

                <div class="mb-3 row" style="width: 400px;">
                    <label for="password" class="col-sm-3 col-form-label">Password</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" name="password" id="password">
                        <span id="passwordHelpInline" class="form-text">Must be 8-20 characters long.</span>
                    </div>
                </div>

                <div class="mb-3 row" style="width: 400px;">
                    <label for="confirm_password" class="col-sm-3 col-form-label">Confirm Password</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" name="confirm_password" id="confirm_password">
                        <span id="passwordHelpInline" class="form-text">Must be same as password.</span>
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>
            </form>
        </div>
    </div>

<?= $this->endSection() ?>