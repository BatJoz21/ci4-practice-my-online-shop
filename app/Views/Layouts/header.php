<nav class="navbar navbar-expand-lg bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand mb-0 h1 text-light" href="<?= base_url('') ?>">MyOnlineShop</a>

        <button class="navbar-toggler px-4" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>

    <div class="collapse navbar-collapse px-4" id="mainNav">
        <ul class="navbar-nav me-auto">
            <li class="nav-item">
                <a class="nav-link text-light" href="<?= base_url('') ?>">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light" href="<?= base_url('products') ?>">Products</a>
            </li>
        </ul>

        <ul class="navbar-nav ms-auto">
            <?php if(session()->get('isLoggedIn')): ?>
                <?php if(session()->get('role') === 'customer'): ?>
                    <li class="nav-item">
                        <a class="nav-link position-relative text-light" href="<?= base_url("cart") ?>">
                            My Cart
                            <span class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle">0</span>
                        </a>
                    </li>
                <?php elseif(session()->get('role') === 'merchant'): ?>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="<?= base_url("my-product") ?>">My Products</a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link text-light" href="<?= base_url("profile") ?>"><?= esc(session()->get("username")) ?></a>
                </li>
                <li class="nav-item">
                    <?= form_open('logout') ?>
                        <button class="nav-link text-light" type="submit">Logout</button>
                    </form>
                </li>
            <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link text-light" href="<?= base_url("login") ?>">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="<?= base_url("register") ?>">Register</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>