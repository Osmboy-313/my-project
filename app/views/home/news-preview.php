<?php

// echo '<pre>';
// print_r($latestPosts);
// echo '</pre>';

$tags = explode(',', $post['post_tags']);
$dateAndTime = new DateTime($post['created_at']);

?>

<div class="news-page news-page--preview">


    <div class="news-search">

        <div class="news-search__title">Search Posts</div>

        <div class="news-search__field">
            <form action="">

                <div class="news-search__input-box">
                    <input type="text" name="search" class="search-input" placeholder="Search Posts">
                    <i class='bx bx-search'></i>
                    <i class='bx bx-x right-icon'></i>
                </div>

            </form>
        </div>

    </div>


    <div class="news-post-preview">

        <div class="news-post-preview__title"> <span> <?= $post['post_title'] ?> </span> </div>

        <div class="news-post-preview__tags">

            <?php foreach ($tags as $tag): ?>
                <span class="news-post-preview__tag"> <i class='bx bxs-purchase-tag'></i> <span> <?= $tag ?> </span> </span>
            <?php endforeach ?>

            <span class="news-post-preview__tag">
                <i class='bx bxs-calendar'></i>
                <span> <?= $dateAndTime->format('d-m-Y') ?> </span>
            </span>

            <span class="news-post-preview__tag">
                <i class='bx bx-time'></i>
                <span> <?= $dateAndTime->format('h:i:s A') ?> </span>
            </span>

        </div>

        <div class="news-post-preview__image"><img src="<?= 'assets/uploads/permanent/' . $post['post_image'] ?>" alt=""></div>

        <div class="news-post-preview__description"> <?= $post['post_description'] ?> </div>

    </div>


    <div class="news-page__list">

        <div class="news-page__heading--list">Recent Posts</div>

        <?php if(empty($latestPosts)) : ?>
            <div class="alert active">No Other Posts to Show</div>
        <?php endif ?>

        <div class="news-page__list">

            <?php foreach ($latestPosts as $latestPost): ?>

                <?php $tags = explode(',', $latestPost['post_tags']) ?>
                <?php $dateAndTime = new DateTime($latestPost['created_at']) ?>

                <div class="news-post">

                    <div class="news-post__image"><img src=" <?= 'assets/uploads/permanent/' . $latestPost['post_image'] ?> " alt=""></div>

                    <div class="news-post__details">

                        <div class="news-post__title"> <?= $latestPost['post_title'] ?> </div>

                        <div class="news-post__tags">

                            <?php foreach ($tags as $tag): ?>
                                <span> <i class='bx bxs-purchase-tag'></i> <span><?= $tag ?></span> </span>
                            <?php endforeach ?>

                            <span> <i class='bx bxs-calendar'></i> <span> <?= $dateAndTime->format('d-m-Y') ?> </span> </span>
                            <span> <i class='bx bx-time'></i> <span> <?= $dateAndTime->format('h:i:s A') ?> </span> </span>

                        </div>

                        <div class="news-post__description"> <?= $latestPost['post_description'] ?> </div>

                        <div class="news-post__buttons">

                            <a href="<?= url('home', 'preview', ['id' => $latestPost['id']]) ?>">
                                <span>Read More</span>
                            </a>

                        </div>

                    </div>

                </div>

            <?php endforeach ?>


        </div>


    </div>


</div>