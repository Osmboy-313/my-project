<?php

$paginationPages = paginationDesign($currentPage, $totalPages);

?>

<div class="title"><span>Profile</span></div>

<div class="main-content profile-preview posts ">

    <!-- <section class="profile-details">
        <h2 class="profile-details__title">Profile Details</h2>

        <div class="profile-details__content">
            <div class="profile-details__item">
                <span class="profile-details__label">ID:</span>
                <span class="profile-details__value"><?= $user['id'] ?></span>
            </div>

            <div class="profile-details__item">
                <span class="profile-details__label">Username:</span>
                <span class="profile-details__value"><?= $user['username'] ?></span>
            </div>

            <div class="profile-details__item">
                <span class="profile-details__label">Email:</span>
                <span class="profile-details__value"><?= $user['email'] ?></span>
            </div>

            <div class="profile-details__item">
                <span class="profile-details__label">Role:</span>
                <span class="profile-details__value"><?= $user['user_type'] ?></span>
            </div>

            <?php if ($_SESSION['user']['user_type'] === 'boss') : ?>
                <div class="profile-details__item profile-details__actions">
                    <span class="profile-details__label">Action:</span>

                    <a href="#" class="btn btn--link">Delete</a>

                    <button
                        type="button"
                        class="btn btn--delete"
                        data-modal-target="#del-modal"
                        data-title="Delete this User?"
                        data-message="This User will be permanently deleted!"
                        data-form="delete-user-form">
                        Delete
                    </button>

                </div>
            <?php endif; ?>
        </div>
    </section> -->



    <section class="profile-details-card">

        <h2 class="profile-details-card__title">Profile Details</h2>

        <div class="profile-details-card__grid">
            <!-- Info rows -->
            <div class="profile-details-card__row">
                <span class="label">ID</span>
                <span class="value"><?= $user['id'] ?></span>
            </div>

            <div class="profile-details-card__row">
                <span class="label">Username</span>
                <span class="value"><?= $user['username'] ?></span>
            </div>

            <div class="profile-details-card__row">
                <span class="label">Email</span>
                <span class="value"><?= $user['email'] ?></span>
            </div>

            <div class="profile-details-card__row">
                <span class="label">Role</span>
                <span class="value"><?= $user['user_type'] ?></span>
            </div>

            <?php if ($_SESSION['user']['user_type'] === 'boss') : ?>
                <div class="profile-details-card__row actions">
                    <span class="label">Actions</span>
                    <div class="value">

                        <button
                            type="button"
                            class="btn btn--red"
                            data-modal-target="#del-modal"
                            data-title="Delete this User?"
                            data-message="This User will be permanently deleted!"
                            data-form="delete-user-form">
                            Delete
                        </button>

                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>





    <div class="post-title">Posts</div>



    <?php if (empty($posts)) : ?>

        <div class="alert active"><span>No Posts Yet!</span></div>

    <?php else : ?>

        <div class="post-container">

            <?php foreach ($posts as $post) : ?>

                <?php $tags = explode(',', $post['post_tags']) ?>
                <?php $dateAndTime = new DateTime($post['created_at']) ?>

                <article class="post-card">


                    <section class="post-card__content">

                        <div class="post-card__image">
                            <img src="<?= 'assets/uploads/permanent/' . $post['post_image'] ?>" alt="Post image">
                        </div>


                        <div class="post-card__details">

                            <p><strong>Post ID:</strong> <span> <?= $post['id'] ?> </span></p>
                            <p><strong>Post Title:</strong> <span> <?= $post['post_title'] ?> </span></p>

                            <div class="post-card__tags">
                                <strong>Tags:</strong>

                                <?php foreach ($tags as $tag): ?>
                                    <span class="tag"> <i class='bx bxs-purchase-tag'></i> <span> <?= $tag ?> </span> </span>
                                <?php endforeach ?>


                                <span class="tag"> <i class='bx bxs-calendar'></i> <span> <?= $dateAndTime->format('d-m-Y') ?> </span> </span>
                                <span class="tag"> <i class='bx bx-time'></i> <span> <?= $dateAndTime->format('h:i:s A') ?> </span> </span>

                            </div>

                            <p><strong>Category:</strong> <span> <?= $post['post_category'] ?> </span></p>

                            <p>
                                <strong>Description:</strong>
                                <span> <?= $post['post_description'] ?> </span>
                            </p>

                            <div class="post-card__actions">
                                <a href="#" class="btn btn--preview">View Full Post</a>
                                <a href="#" class="btn btn--delete">Delete</a>

                                <button
                                    type="button"
                                    class="btn btn--delete"
                                    data-modal-target="#del-modal"
                                    data-title="Delete this Post?"
                                    data-message="This Post will be permanently deleted !"
                                    data-form="delete-post-form">

                                    Delete

                                </button>

                            </div>

                        </div>
                    </section>

                </article>

            <?php endforeach ?>


        </div>

        <div class="pagination">

            <div class="pagination__wrapper">

                <div class="dummy__div">Hallo</div>

                <div class="pagination__controls">

                    <ul>


                        <li class="<?= $currentPage === 1 ? 'disabled' : '' ?>">
                            <a href="<?= url('profile', 'preview', ['id' => $user['id'], 'page' => max(1, $currentPage - 1)]) ?>">

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
                                    <a href="<?= url('profile', 'preview', ['id' => $user['id'], 'page' => $page]) ?>"> <?= $page ?> </a>
                                </li>

                            <?php endif ?>

                        <?php endforeach ?>

                        <li class="<?= $currentPage == $totalPages ? 'disabled' : '' ?>">
                            <a href="<?= url('profile', 'preview', ['id' => $user['id'], 'page' => min($totalPages, $currentPage + 1)]) ?>">

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






    <section class="posts-section">
        <h2 class="section-title">Posts</h2>

        <?php if (empty($posts)) : ?>

            <div class="alert active"><span>No Posts Yet!</span></div>

        <?php else : ?>

            <div class="posts-grid">
                <?php foreach ($posts as $post) : ?>
                    <?php $tags = explode(',', $post['post_tags']) ?>
                    <?php $date = new DateTime($post['created_at']) ?>

                    <article class="post-card">
                        <div class="post-card__image">
                            <img src="<?= 'assets/uploads/permanent/' . $post['post_image'] ?>" alt="Post image">
                        </div>

                        <div class="post-card__body">
                            <div class="post-card__info">
                                <p><span class="label">Post ID:</span> <?= $post['id'] ?></p>
                                <p><span class="label">Title:</span> <?= $post['post_title'] ?></p>
                                <p><span class="label">Category:</span> <?= $post['category_name'] ?></p>
                            </div>

                            <div class="post-card__tags">
                                <?php foreach ($tags as $tag) : ?>
                                    <span class="tag"><i class="bx bxs-purchase-tag"></i><?= $tag ?></span>
                                <?php endforeach; ?>
                                <span class="tag"><i class="bx bxs-calendar"></i><?= $date->format('d-m-Y') ?></span>
                                <span class="tag"><i class="bx bx-time"></i><?= $date->format('h:i:s A') ?></span>
                            </div>

                            <p class="post-card__desc"><?= $post['post_description'] ?></p>

                            <div class="post-card__actions">
                                <a href="#" class="btn btn--preview">View Full Post</a>

                                <button
                                    type="button"
                                    class="btn btn--red"
                                    data-modal-target="#del-modal"
                                    data-title="Delete this Post?"
                                    data-message="This Post will be permanently deleted!"
                                    data-form="delete-post-form">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>

            </div>

    </section>





    <div class="pagination">

        <div class="pagination__wrapper">

            <div class="dummy__div">Hallo</div>

            <div class="pagination__controls">

                <ul>


                    <li class="<?= $currentPage === 1 ? 'disabled' : '' ?>">
                        <a href="<?= url('profile', 'preview', ['id' => $user['id'], 'page' => max(1, $currentPage - 1)]) ?>">

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
                                <a href="<?= url('profile', 'preview', ['id' => $user['id'], 'page' => $page]) ?>"> <?= $page ?> </a>
                            </li>

                        <?php endif ?>

                    <?php endforeach ?>

                    <li class="<?= $currentPage == $totalPages ? 'disabled' : '' ?>">
                        <a href="<?= url('profile', 'preview', ['id' => $user['id'], 'page' => min($totalPages, $currentPage + 1)]) ?>">

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

<?php endif; ?>


</div>