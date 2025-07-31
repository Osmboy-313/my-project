<?php

include VIEWPATH . '/layouts/head.php';

?>

<body>

    <div class="container container__public">

        <div class="header">

            <div class="logo">
                <a href="<?= url('home', 'index') ?>"><img src="assets/images/news.jpg" alt=""></a>
            </div>

            <div class="options">

                <ul>
                    <li><a href="">Business</a></li>
                    <li><a href="">Entertainment</a></li>
                    <li><a href="">Sports</a></li>
                    <li><a href="">Politics</a></li>
                </ul>


                <?php if (isset($_SESSION['user'])) { ?>

                    <div class="user-dropdown" id="user-dropdown">
                        <span><?= $_SESSION['user']['username'] ?></span>
                        <i class='bx bx-chevron-down '></i>
                        <div class="main-dropdown" id="main-dropdown">

                            <ul>

                                <li>
                                    <a href="<?= url('profile', 'get', ['id' => $id]) ?>">
                                        <i class='bx bx-user'></i> <span>Profile</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="<?= url('dashboard', 'index') ?>">
                                        <i class='bx bxs-dashboard'></i> <span>Dashboard</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="<?= url('auth', 'logout') ?>">
                                        <i class='bx bx-power-off'></i> <span>logout</span>
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </div>

                <?php } else { ?>

                    <a href="<?= url('auth', 'index') ?>" class="login-btn"><span>Login / Register</span></a>

                <?php } ?>


            </div>

        </div>

        <div class="content">

            <?php echo $content ?? ''; ?>

        </div>

        <div class="footer">

            <span>Footer</span>

        </div>

    </div>

    <script type="module" src="assets/script/script.js"></script>

</body>

</html>