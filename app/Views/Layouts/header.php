<nav class="navbar navbar-expand-lg bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand mb-0 h1 text-light" href="<?= base_url('') ?>">MyOnlineShop</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link text-light text-nowrap" href="<?= base_url('') ?>">Home</a>
                </li>
                <?php if(empty(session('user')) || session('user')['role'] != 'merchant'): ?>
                    <li class="nav-item">
                        <a class="nav-link text-light text-nowrap" href="<?= base_url('products') ?>">Products</a>
                    </li>
                <?php endif; ?>
                <?php if(session()->get('logged_in')): ?>
                    <?php if(session('user')['role'] === 'customer'): ?>
                        <li class="nav-item me-2">
                            <a class="nav-link position-relative text-light" href="<?= base_url("cart") ?>">
                                My Cart
                                <span class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle-x">
                                    <?= session("totalInCart") ?>
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link position-relative text-light" href="<?= base_url("orders") ?>">
                                My Orders
                            </a>
                        </li>
                    <?php elseif(session("user")["role"] === "merchant" || session("user")["role"] === "superadmin"): ?>
                        <li class="nav-item">
                            <a class="nav-link position-relative text-light" href="<?= base_url("merchant/dashboard") ?>">
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light text-nowrap" href="<?= base_url("merchant/products") ?>">
                                Our Products
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link position-relative text-light" href="<?= base_url("merchant/orders") ?>">
                                Orders
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link position-relative text-light" href="<?= base_url("merchant/payments") ?>">
                                Payments
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if(session('user')['role'] === 'superadmin'): ?>
                        <li class="nav-item">
                            <a href="<?= base_url("admin/users") ?>" class="nav-link position-relative text-light">Users</a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>

            <ul class="navbar-nav ms-auto align-items-lg-center">
                <?php if(session()->get('logged_in')): ?>
                    <li class="nav-item">
                        <a class="nav-link text-light text-nowrap" href="<?= base_url("profile") ?>"><?= esc(session('user')['name']) ?></a>
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
    </div>
</nav>