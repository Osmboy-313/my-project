<?php

$paginationPages = paginationDesign($currentPage, $totalPages);

?>

<div class="each-tab-content user <?= $activeTab === '#user' ? 'active' : '' ?> " id="user" data-tab-content>

    <?php if (empty($users)) : ?>

        <div class="alert active"><span>No Users Found!</span></div>

    <?php else : ?>

        <!-- <table>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Profile</th>
                </tr>
            </thead>

            <tbody>

                <?php // foreach ($users as $user) : ?>

                    <tr>
                        <td> <?= $serialNumber ?> </td>
                        <td> <?= $user['username'] ?> </td>
                        <td> <?= $user['email'] ?> </td>
                        <td>
                            <a href="<?= url('profile', 'preview', ['id' => $user['id']]) ?>" class="view-profile-btn">
                                <span>View Profile</span>
                            </a>
                        </td>
                    </tr>

                <?php // endforeach ?>

            </tbody>

        </table> -->

        <table class="custom-table styled-table">
            <thead>
                <tr>

                    <th>#</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th class="action">Profile</th>
                    <!-- <th class="action">Actions</th> -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $serialNumber++ ?></td>
                        <td><?= $user['username'] ?></td>
                        <td> <?= $user['email'] ?> </td>
                        <td>
                            <div class="table-actions">

                                <a 
                                    class="btn"
                                    href="<?= url('profile', 'preview', ['id' => $user['id']]) ?>" >
                                    View Profile
                                </a>

                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>



        <div class="pagination">

            <div class="pagination__wrapper">

                <div class="dummy__div">Hallo</div>

                <div class="pagination__controls">

                    <ul>


                        <li class="<?= $currentPage === 1 ? 'disabled' : '' ?>">
                            <a href="<?= url('user', 'index', [ 'tab' => '#user' ,'page' => max(1, $currentPage - 1)]) ?>">

                                <i class='bx bx-chevron-left'></i>

                            </a>
                        </li>

                        <?php foreach ($paginationPages as $page): ?>

                            <?php if ($page === '...'): ?>

                                <li>
                                    <p> <?= $page ?> </p>
                                </li>

                            <?php else: ?>

                                <li class="<?= $page === $currentPage ? 'active' : '' ?>">
                                    <a href="<?= url('user', 'index', [ 'tab' => '#user' ,'page' => $page]) ?>"> <?= $page ?> </a>
                                </li>

                            <?php endif ?>

                        <?php endforeach ?>

                        <li class="<?= $currentPage == $totalPages ? 'disabled' : '' ?>">
                            <a href="<?= url('user', 'index', [ 'tab' => '#user' ,'page' => min($totalPages, $currentPage + 1)]) ?>">

                                <i class='bx bx-chevron-right'></i>

                            </a>
                        </li>


                    </ul>

                </div>

                <div class="pagination__summary">

                    <p> Showing <?= $start ?> - <?= $end ?> of <?= $totalRecords ?> </p>

                </div>

            </div>

        </div>


    <?php endif ?>

</div>



<div class="each-tab-content admin <?= $activeTab === '#admin' ? 'active' : '' ?> " id="admin" data-tab-content>

    <?php if (empty($admins)) : ?>

        <div class="alert active"><span>No Admins Found!</span></div>

    <?php else : ?>


        <table class="custom-table styled-table">
            <thead>
                <tr>

                    <th>#</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th class="action">Profile</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($admins as $admin): ?>
                    <tr>
                        <td><?= $serialNumber++ ?></td>
                        <td><?= $admin['username'] ?></td>
                        <td> <?= $admin['email'] ?> </td>
                        <td>
                            <div class="table-actions">

                                <a 
                                    class="btn"
                                    href="<?= url('profile', 'preview', ['id' => $admin['id']]) ?>" >
                                    View Profile
                                </a>

                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>


        <div class="pagination">

            <div class="pagination__wrapper">

                <div class="dummy__div">Hallo</div>

                <div class="pagination__controls">

                    <ul>


                        <li class="<?= $currentPage === 1 ? 'disabled' : '' ?>">
                            <a href="<?= url('user', 'index', [ 'tab' => '#admin' ,'page' => max(1, $currentPage - 1)]) ?>">

                                <i class='bx bx-chevron-left'></i>

                            </a>
                        </li>

                        <?php foreach ($paginationPages as $page): ?>

                            <?php if ($page === '...'): ?>

                                <li>
                                    <p> <?= $page ?> </p>
                                </li>

                            <?php else: ?>

                                <li class="<?= $page === $currentPage ? 'active' : '' ?>">
                                    <a href="<?= url('user', 'index', [ 'tab' => '#admin' ,'page' => $page]) ?>"> <?= $page ?> </a>
                                </li>

                            <?php endif ?>

                        <?php endforeach ?>

                        <li class="<?= $currentPage == $totalPages ? 'disabled' : '' ?>">
                            <a href="<?= url('user', 'index', [ 'tab' => '#admin' ,'page' => min($totalPages, $currentPage + 1)]) ?>">

                                <i class='bx bx-chevron-right'></i>

                            </a>
                        </li>


                    </ul>

                </div>

                <div class="pagination__summary">

                    <p> Showing <?= $start ?> - <?= $end ?> of <?= $totalRecords ?> </p>

                </div>

            </div>

        </div>

    <?php endif ?>

</div>



<div class="each-tab-content boss <?= $activeTab === '#boss' ? 'active' : '' ?> " id="boss" data-tab-content>

    <?php if (empty($bosses)) : ?>

        <div class="alert active"><span>No Bosses Found!</span></div>

    <?php else : ?>

        <table class="custom-table styled-table">
            <thead>
                <tr>

                    <th>#</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th class="action">Profile</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bosses as $boss): ?>
                    <tr>
                        <td><?= $serialNumber++ ?></td>
                        <td><?= $boss['username'] ?></td>
                        <td> <?= $boss['email'] ?> </td>
                        <td>
                            <div class="table-actions">

                                <a 
                                    class="btn"
                                    href="<?= url('profile', 'preview', ['id' => $boss['id']]) ?>" >
                                    View Profile
                                </a>

                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>


        <div class="pagination">

            <div class="pagination__wrapper">

                <div class="dummy__div">Hallo</div>

                <div class="pagination__controls">

                    <ul>


                        <li class="<?= $currentPage === 1 ? 'disabled' : '' ?>">
                            <a href="<?= url('user', 'index', [ 'tab' => '#boss' ,'page' => max(1, $currentPage - 1)]) ?>">

                                <i class='bx bx-chevron-left'></i>

                            </a>
                        </li>

                        <?php foreach ($paginationPages as $page): ?>

                            <?php if ($page === '...'): ?>

                                <li>
                                    <p> <?= $page ?> </p>
                                </li>

                            <?php else: ?>

                                <li class="<?= $page === $currentPage ? 'active' : '' ?>">
                                    <a href="<?= url('user', 'index', [ 'tab' => '#boss' ,'page' => $page]) ?>"> <?= $page ?> </a>
                                </li>

                            <?php endif ?>

                        <?php endforeach ?>

                        <li class="<?= $currentPage == $totalPages ? 'disabled' : '' ?>">
                            <a href="<?= url('user', 'index', [ 'tab' => '#boss' ,'page' => min($totalPages, $currentPage + 1)]) ?>">

                                <i class='bx bx-chevron-right'></i>

                            </a>
                        </li>


                    </ul>

                </div>

                <div class="pagination__summary">

                    <p> Showing <?= $start ?> - <?= $end ?> of <?= $totalRecords ?> </p>

                </div>

            </div>

        </div>

    <?php endif ?>

</div>