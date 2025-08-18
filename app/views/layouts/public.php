<?php

include VIEWPATH . '/layouts/head.php';

if (isset($_SESSION['user'])) {
    $id = (int) $_SESSION['user']['id'] ?? 0;
    $username = $_SESSION['user']['username'];
    $user_type = $_SESSION['user']['user_type'];
}

?>

<body>

    <div class="container container__public">

        <!-------------------- Header -------------------->

        <div class="header">

            <div class="header__wrapper">

                <div class="header__logo">
                    <a href="<?= url('home', 'index') ?>" class="header__logo-link">Connect Sphere</a>
                </div>

                <div class="header__nav">
                    <ul class="header__menu">
                        <li class="header__item"><a href="#" class="header__link">Business</a></li>
                        <li class="header__item"><a href="#" class="header__link">Entertainment</a></li>
                        <li class="header__item"><a href="#" class="header__link">Sports</a></li>
                        <li class="header__item"><a href="#" class="header__link">Politics</a></li>
                    </ul>
                </div>

                <div class="header__auth">

                    <?php if (isset($_SESSION['user'])) : ?>

                        <div class="header__dropdown" id="user-dropdown">

                            <span class="header__username"><?= $_SESSION['user']['username'] ?></span>
                            <i class='bx bx-chevron-down'></i>

                            <div class="header__main-dropdown" id="main-dropdown">

                                <ul class="header__menu">

                                    <li class="header__item">
                                        <a href="<?= url('profile', 'myProfile', ['id' => $id]) ?>" class="header__link">
                                            <i class='bx bx-user'></i> <span>Profile</span>
                                        </a>
                                    </li>

                                    <li class="header__item">
                                        <a href="<?= url('dashboard', 'index') ?>" class="header__link">
                                            <i class='bx bxs-dashboard'></i> <span>Dashboard</span>
                                        </a>
                                    </li>

                                    <li class="header__item">
                                        <a href="<?= url('auth', 'logout') ?>" class="header__link">
                                            <i class='bx bx-power-off'></i> <span>Logout</span>
                                        </a>
                                    </li>

                                </ul>

                            </div>

                        </div>

                    <?php else : ?>

                        <a href="<?= url('auth', 'index') ?>" class="header__login-btn">
                            <span>Login / Register</span>
                        </a>

                    <?php endif ?>

                </div>

            </div>

        </div>

        <!-------------------- Content -------------------->

        <div class="content">

            <?php echo $content ?? ''; ?>

        </div>

        <!-------------------- Footer -------------------->

        <div class="footer">

            <div class="footer__wrapper">

                <span>Footer</span>

            </div>

        </div>
        

    </div>

    <script type="module" src="assets/script/script.js"></script>

</body>

</html>