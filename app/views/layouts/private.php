<?php

include VIEWPATH . '/layouts/head.php';

$id = (int) $_SESSION['user']['id'] ?? 0;
$username = $_SESSION['user']['username'];
$user_type = $_SESSION['user']['user_type'];

switch ($user_type) {

    case 'user':
        $menuItems = [
            ['controller' => 'post', 'action' => 'add', 'label' => 'Add Post'],
            ['controller' => 'post', 'action' => 'index', 'label' => 'My Posts'],
            ['controller' => 'category', 'action' => 'index', 'label' => 'Categories'],
        ];
        break;

    case 'admin':
        $menuItems = [
            ['controller' => 'user', 'action' => 'index', 'label' => 'Users'],
            ['controller' => 'admin', 'action' => 'index', 'label' => 'Admins'],
            ['controller' => 'post', 'action' => 'add', 'label' => 'Add Post'],
            ['controller' => 'post', 'action' => 'index', 'label' => 'My Posts'],
            ['controller' => 'category', 'action' => 'index', 'label' => 'Categories'],
        ];
        break;

    case 'boss':
        $menuItems = [
            ['controller' => 'user', 'action' => 'index', 'label' => 'Users'],
            ['controller' => 'admin', 'action' => 'index', 'label' => 'Admins'],
            ['controller' => 'post', 'action' => 'add', 'label' => 'Add Post'],
            ['controller' => 'post', 'action' => 'index', 'label' => 'My Posts'],
            ['controller' => 'category', 'action' => 'index', 'label' => 'Categories'],
            ['controller' => 'code', 'action' => 'indexs', 'label' => 'Codes'],
        ];
        break;
}

?>

<body>

    <div class="container container__private">

        <div class="sidebar" id="sidebar">
            <div class="sidebar__title"><a href="index.php"><span>Home</span></a></div>

            <ul class="sidebar__menu">

                <?php foreach ($menuItems as $items): ?>
                    <li class=" sidebar__item <?= active($items['controller'], $items['action']) ?>">
                        <a href="<?= url($items['controller'], $items['action']) ?>" class="sidebar__link" >
                            <!-- <i class='bx bx-book'></i> --> <i class='bx bx-chevrons-right' ></i>  <?= $items['label'] ?>
                        </a>
                    </li>
                <?php endforeach; ?>

            </ul>

        </div>

        <div class="main-layout">

            <div class="header">

                <div id="toggle-sidebar" class="header__toggle-sidebar">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>

                <div class="header__dropdown" id="user-dropdown">

                    <span><?= $username ?></span>
                    <i class='bx bx-chevron-down '></i>
                    
                    <div class="header__main-dropdown" id="main-dropdown">

                        <ul class="header__menu">

                            <li class="header__item">
                                <a href="<?= url('profile', 'get', ['id' => $id]) ?>" class="header__link">
                                    <i class='bx bx-user'></i> <span>Profile</span>
                                </a>
                            </li>

                            <li class="header__item">
                                <a href="<?= url('dashboard', 'index') ?>" class="header__link">
                                    <i class='bx bxs-dashboard'></i> <span>Dashboard</span>
                                </a>
                            </li>

                            <li class="header__item"> 
                                <a href="<?= url('auth', 'logout', ['id' => $id]) ?>" class="header__link"> 
                                    <i class='bx bx-power-off'></i> <span>logout</span>
                                </a>

                            </li>

                        </ul>

                    </div>

                </div>

            </div>


            <div class="content">

                <div class="content-card">

                    <?php echo $content ?? ""; ?>

                </div>

            </div>

            <?php echo $modals ?? ""; ?>

            <div class="footer">Footer</div>

        </div>

    </div>

    <script type="module" src="assets/script/script.js"></script>

</body>

</html>