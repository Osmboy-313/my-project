<?php

$searchQuery = $searchQuery ?? '';
$hasSearchResults = !empty($searchQuery);

?>

<div class="news-page news-page--list">

    <div class="news-search">

        <div class="news-search__title">Search Posts</div>

        <div class="news-search__field">
            <form action="index.php" method="GET">
                <input type="hidden" name="c" value="home">
                <input type="hidden" name="a" value="index">
                
                <div class="news-search__input-box">
                    <input type="text" name="search" class="search-input" placeholder="Search Posts" value="<?= htmlspecialchars($searchQuery) ?>">
                    <i class='bx bx-search'></i>

                    <!-- <button type="submit"> <i class='bx bx-search'></i> </button> -->

                    <?php if (!empty($searchQuery)): ?>
                       <a href="index.php?c=home&a=index"> <i class='bx bx-x right-icon'> </i></a>
                    <?php endif; ?>
                </div>

            </form>
        </div>

        <?php if ($hasSearchResults): ?>
            <div class="search-results-info">
                <p>Search results for: <strong>"<?= htmlspecialchars($searchQuery) ?>"</strong></p>
                <p>Found <?= count($posts) ?> post(s)</p>
            </div>
        <?php endif; ?>

    </div>

    <div class="news-page__list">

        <?php if (empty($posts)): ?>

            <div class="no-posts-message">
                <?php if ($hasSearchResults): ?>
                    <p>No posts found matching your search: <strong>"<?= htmlspecialchars($searchQuery) ?>"</strong></p>
                    <p>Try different keywords or <a href="index.php?c=home&a=index">browse all posts</a></p>
                <?php else: ?>
                    <p>No posts available at the moment.</p>
                <?php endif; ?>
            </div>

        <?php else: ?>

            <?php foreach ($posts as $post): ?>

                <?php $tags = explode(',', $post['post_tags']) ?>
                <?php $dateAndTime = new DateTime($post['created_at']) ?>

                <div class="news-post">

                    <div class="news-post__image"><img src=" <?= 'assets/uploads/permanent/' . $post['post_image'] ?> " alt=""></div>

                    <div class="news-post__details">

                        <div class="news-post__title"> <?= $post['post_title'] ?> </div>

                        <div class="news-post__tags">

                            <?php foreach ($tags as $tag): ?>
                                <span> <i class='bx bxs-purchase-tag'></i> <span><?= $tag ?></span> </span>
                            <?php endforeach ?>

                            <span> <i class='bx bxs-calendar'></i> <span> <?= $dateAndTime->format('d-m-Y') ?> </span> </span>
                            <span> <i class='bx bx-time'></i> <span> <?= $dateAndTime->format('h:i:s A') ?> </span> </span>

                        </div>

                        <div class="news-post__description"> <?= $post['post_description'] ?> </div>

                        <div class="news-post__buttons">

                            <a href="<?= url('home', 'preview', ['id' => $post['id']]) ?>">
                                <span>Read More</span>
                            </a>

                        </div>

                    </div>

                </div>

            <?php endforeach ?>
        <?php endif; ?>

    </div>

</div>