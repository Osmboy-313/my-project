<?php

$paginationPages = paginationDesign($currentPage, $totalPages);

?>


<div class="each-tab-content admin <?= $activeTab === '#admin' ? 'active' : '' ?> " id="admin" data-tab-content>

    <?php if (empty($adminCodes)) : ?>

        <div class="alert active"><span>No Admin Codes Found!</span></div>

    <?php else : ?>

        <table>
            <thead>
                <tr>
                    <th>Serial Number</th>
                    <th>Code</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

                <?php foreach ($adminCodes as $adminCode): ?>

                    <tr>
                        <td> <?= $serialNumber++ ?> </td>
                        <td> <?= $adminCode['admin_code'] ?> </td>
                        <td>
                            <div class="buttons">

                                <button
                                    class="edit-btn"
                                    data-modal-target="#edit-modal"
                                    data-title="Edit Admin Code"
                                    data-label="Admin Code"
                                    data-placeholder="Enter admin code"
                                    data-form="edit-admin-form"
                                    data-id="<?= $adminCode['id'] ?>"
                                    data-column="admin_code"
                                    >
                                    Edit
                                </button>

                                <button
                                    class="del-btn"
                                    data-modal-target="#del-modal"
                                    data-title="Delete Admin Code?"
                                    data-message = "This Admin Code will be permanently deleted!"
                                    data-form="delete-admin-form"
                                    data-id="<?= $adminCode['id'] ?>"
                                    data-column="admin_code"
                                    >
                                    Delete
                                </button>

                            </div>
                        </td>
                    </tr>

                <?php endforeach ?>

            </tbody>

        </table>

        <div class="pagination">

            <div class="pagination__wrapper">

                <div class="dummy__div">Hallo</div>

                <div class="pagination__controls">

                    <ul>


                        <li class="<?= $currentPage === 1 ? 'disabled' : '' ?>">
                            <a href="<?= url('code', 'index', ['tab' => '#admin', 'page' => max(1, $currentPage - 1)]) ?>">

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
                                    <a href="<?= url('code', 'index', ['tab' => '#admin', 'page' => $page]) ?>"> <?= $page ?> </a>
                                </li>

                            <?php endif ?>

                        <?php endforeach ?>

                        <li class="<?= $currentPage == $totalPages ? 'disabled' : '' ?>">
                            <a href="<?= url('code', 'index', ['tab' => '#admin', 'page' => min($totalPages, $currentPage + 1)]) ?>">

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

    <?php if (empty($bossCodes)) : ?>

        <div class="alert active"><span>No Boss Codes Found!</span></div>

    <?php else : ?>

        <table>
            <thead>
                <tr>
                    <th>Serial Number</th>
                    <th>Code</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

                <?php foreach ($bossCodes as $bossCode): ?>

                    <tr>
                        <td> <?= $serialNumber++ ?> </td>
                        <td> <?= $bossCode['boss_code'] ?> </td>
                        <td>
                            <div class="buttons">

                            <button
                                    class="edit-btn"
                                    data-modal-target="#edit-modal"
                                    data-title="Edit Boss Code"
                                    data-label="Boss Code"
                                    data-placeholder="Enter boss code"
                                    data-form="edit-boss-form"
                                    data-id="<?= $bossCode['id'] ?>"
                                    data-column="boss_code"
                                    >
                                    Edit
                                </button>

                                <button
                                    class="del-btn"
                                    data-modal-target="#del-modal"
                                    data-title="Delete Boss Code?"
                                    data-message = "This Boss Code will be permanently deleted!"
                                    data-form="delete-boss-form"
                                    data-id="<?= $bossCode['id'] ?>"
                                    data-column="boss_code"
                                    >
                                    Delete
                                </button>

                            </div>
                        </td>
                    </tr>

                <?php endforeach ?>

            </tbody>

        </table>

        <div class="pagination">

            <div class="pagination__wrapper">

                <div class="dummy__div">Hallo</div>

                <div class="pagination__controls">

                    <ul>


                        <li class="<?= $currentPage === 1 ? 'disabled' : '' ?>">
                            <a href="<?= url('code', 'index', ['tab' => '#boss', 'page' => max(1, $currentPage - 1)]) ?>">

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
                                    <a href="<?= url('code', 'index', ['tab' => '#boss', 'page' => $page]) ?>"> <?= $page ?> </a>
                                </li>

                            <?php endif ?>

                        <?php endforeach ?>

                        <li class="<?= $currentPage == $totalPages ? 'disabled' : '' ?>">
                            <a href="<?= url('code', 'index', ['tab' => '#boss', 'page' => min($totalPages, $currentPage + 1)]) ?>">

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