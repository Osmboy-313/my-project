<?php

$recordsPerPage = 3;

$currentPage = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$currentPage = max(1, $currentPage);
$totalRecords = count($posts);
$totalPages = max(1, ceil($totalRecords / $recordsPerPage));
$currentPage = min($currentPage, $totalPages);


$start = ($currentPage - 1) * $recordsPerPage;
$end = $start + $recordsPerPage;
$serialNo = 1;
$pageData = array_slice($posts, $start, $recordsPerPage);

function paginationDesign($currentPage, $totalPages)
{
    $pages = [];

    if ($totalPages <= 7) {
        for ($i = 1; $i <= $totalPages; $i++) {
            $pages[] = $i;
        }
    } else {
        if ($currentPage <= 3) {
            $pages = [1, 2, 3, 4, 5, '...', $totalPages];
        } else if ($currentPage >= $totalPages - 3) {
            $pages = [1, '...', $totalPages - 4, $totalPages - 3, $totalPages - 2, $totalPages - 1, $totalPages];
        } else {
            $pages = [1, '...', $currentPage - 1, $currentPage, $currentPage + 1, '...', $totalPages];
        }
    }

    return $pages;
}

$paginationPages = paginationDesign($currentPage, $totalPages);

?>

<div class="title">
    <span>My Posts</span>
    <button><a href=" <?= url('post', 'add') ?> " class="add-category"><span>Add Post</span></a> </button>
</div>

<div class="main-content my-posts">

    <div class="alert <?= empty($posts) ? 'active' : '' ?>"><span>No Posts Found!</span></div>

    <!-- <?php
            echo '<pre>';
            print_r($posts);
            echo '</pre>';
            ?> -->

    <div class="post-container">

        <?php foreach ($pageData as $post): ?>

            <div class="actual-post">

                <div class="post">

                    <div class="post-image">
                        <img src="<?= 'assets/uploads/permanent/' . $post['post_image'] ?>" alt="">
                    </div>

                    <div class="post-content">

                        <div>
                            <span class="column-name"> Sr no : </span>
                            <span> <?= $serialNo ?> </span>
                        </div>

                        <div>
                            <span class="column-name">Post title :</span>
                            <span> <?= $post['post_title'] ?> </span>
                        </div>

                        <div>
                            <span class="column-name">Post tag :</span>
                            <span> <?= $post['post_tags'] ?> </span>
                        </div>

                        <div>
                            <span class="column-name">Post Category :</span>
                            <span> <?= $post['category_name'] ?> </span>
                        </div>

                        <div>
                            <span class="column-name">Post description : </span>
                            <span> <?= $post['post_description'] ?> </span>
                        </div>

                        <div class="buttons">

                            <a href=" <?= url('home', 'preview', ['id' => $post['id']]) ?> " class="preview-btn">
                                <span>View Full Post</span>
                            </a>

                            <a href=" <?= url('post', 'edit', ['id' => $post['id']]) ?> " class="edit-btn"> <span>Edit</span> </a>
                            <a data-modal-target="#del-modal" class="del-btn"><span>Delete</span></a>
                        </div>

                    </div>

                </div>

            </div>

        <?php endforeach ?>

    </div>

    

    <div class="pagination <?= empty($posts) ? 'de-active' : '' ?>">

        <div class="pagination__wrapper">

            <div class="dummy__div">Hallo</div>

            <div class="pagination__controls">

                <ul>


                    <li class="<?= $currentPage === 1 ? 'disabled' : '' ?>">
                        <a href="<?= url('post', 'index', ['page' => max(1, $currentPage - 1)]) ?>">

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
                                <a href="<?= url('post', 'index', ['page' => $page]) ?>"> <?= $page ?> </a>
                            </li>

                        <?php endif ?>

                    <?php endforeach ?>

                    <li class="<?= $currentPage == $totalPages ? 'disabled' : '' ?>">
                        <a href="<?= url('post', 'index', ['page' => min($totalPages, $currentPage + 1)]) ?>">

                            <i class='bx bx-chevron-right'></i>

                        </a>
                    </li>


                </ul>

            </div>

            <div class="pagination__summary">

                <p> Showing <?= $start + 1 ?> - <?= $end ?> of <?= $totalRecords ?> </p>

            </div>

        </div>

    </div>

</div>