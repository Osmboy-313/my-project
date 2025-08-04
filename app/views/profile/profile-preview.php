<?php

// echo '<pre>';
// print_r($user);
// print_r($posts);
// echo '</pre>';

$paginationPages = paginationDesign($currentPage, $totalPages);


?>

<div class="title"><span>Profile</span></div>

<div class="main-content profile-preview posts ">

    <div class="profile-details">

        <div class="title">Profile Details</div>

        <div class="details">

            <div>
                <span class="column-name">ID :</span>
                <span> <?= $user['id'] ?> </span>
            </div>

            <div>
                <span class="column-name">Username :</span>
                <span> <?= $user['username'] ?> </span>
            </div>

            <div>
                <span class="column-name">Email :</span>
                <span> <?= $user['email'] ?> </span>
            </div>

            <div>
                <span class="column-name">Role :</span>
                <span> <?= $user['user_type'] ?> </span>
            </div>

            <?php if ($_SESSION['user']['user_type'] === 'boss') { ?>

                <div class="buttons">
                    <span class="column-name">Action :</span>
                    <a href=""><span>Delete</span></a>
                </div>

            <?php } ?>

        </div>

    </div>



    <div class="post-title">Posts</div>



    <?php if (empty($posts)) : ?>

        <div class="alert active"><span>No Posts Yet!</span></div>

    <?php else : ?>

        <div class="post-container">

            <?php foreach ($posts as $post) : ?>

                <?php $tags = explode(',', $post['post_tags']) ?>
                <?php $dateAndTime = new DateTime($post['created_at']) ?>

                <article class="post-card">

                    <!-- Post Content -->
                    <section class="post-card__content">

                        <!-- Post Image -->
                        <div class="post-card__image">
                            <img src="<?= 'assets/uploads/permanent/' . $post['post_image'] ?>" alt="Post image">
                        </div>

                        <!-- Post Details -->
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

                            <!-- Action Buttons -->
                            <div class="post-card__actions">
                                <a href="#" class="btn btn--preview">View Full Post</a>
                                <a href="#" class="btn btn--edit">Edit</a>
                                <a href="#" class="btn btn--delete">Delete</a>
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
                            <a href="<?= url('profile', 'preview', [ 'id' => $user['id'] ,'page' => max(1, $currentPage - 1)]) ?>">

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
                                    <a href="<?= url('profile', 'preview', ['id' => $user['id'] ,'page' => $page]) ?>"> <?= $page ?> </a>
                                </li>

                            <?php endif ?>

                        <?php endforeach ?>

                        <li class="<?= $currentPage == $totalPages ? 'disabled' : '' ?>">
                            <a href="<?= url('profile', 'preview', ['id' => $user['id'] ,'page' => min($totalPages, $currentPage + 1)]) ?>">

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