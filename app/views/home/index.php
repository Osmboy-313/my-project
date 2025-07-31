<?php



?>

<div class="news-page news-page--list">

    <div class="news-search">

        <div class="news-search__title">Search News</div>

        <div class="news-search__field">
            <form action="">

                <div class="news-search__input-box">
                    <input type="text" name="search" class="search-input" placeholder="Search News">
                    <!-- <button type="submit" class="search-btn" > <i class='bx bx-search-alt' ></i> </button> -->
                    <i class='bx bx-search'></i>
                    <!-- <i class='bx bx-search-alt' ></i> -->
                    <i class='bx bx-x right-icon'></i>
                </div>

            </form>
        </div>

    </div>

    <div class="news-page__list">

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

        <div class="news-post">

            <div class="news-post__image"><img src="assets/images/wallpaperflare.com_wallpaper(1).jpg" alt=""></div>

            <div class="news-post__details">

                <div class="news-post__title"> Nothing </div>

                <div class="news-post__tags">
                    <span> <i class='bx bxs-purchase-tag'></i> <span> Something</span> <span> Nomething</span> </span>
                    <span> <i class='bx bxs-calendar'></i> <span>26-27-2032</span> </span>
                    <span> <i class='bx bx-time'></i> <span> 02:11:30 </span> </span>
                </div>

                <div class="news-post__description">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Maxime impedit neque ducimus aut quis expedita, ut at voluptatem laboriosam atque aliquid et veritatis sapiente? Quam deleniti nobis architecto magnam aliquid pariatur dolores exercitationem dolorem minus magni nulla, quisquam aperiam consequuntur impedit! Illo unde earum consequuntur nemo repudiandae veritatis tempora laborum?</div>

                <div class="news-post__buttons">

                    <a href="<?= url('home', 'preview', ['id' => $post['id']]) ?>">
                        <span>Read More</span>
                    </a>

                </div>

            </div>

        </div>

        <div class="news-post">

            <div class="news-post__image"><img src="assets/images/wallpaperflare.com_wallpaper(1).jpg" alt=""></div>

            <div class="news-post__details">

                <div class="news-post__title"> Nothing </div>

                <div class="news-post__tags">
                    <span> <i class='bx bxs-purchase-tag'></i> <span> Something</span> <span> Nomething</span> </span>
                    <span> <i class='bx bxs-calendar'></i> <span>26-27-2032</span> </span>
                    <span> <i class='bx bx-time'></i> <span> 02:11:30 </span> </span>
                </div>

                <div class="news-post__description">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Maxime impedit neque ducimus aut quis expedita, ut at voluptatem laboriosam atque aliquid et veritatis sapiente? Quam deleniti nobis architecto magnam aliquid pariatur dolores exercitationem dolorem minus magni nulla, quisquam aperiam consequuntur impedit! Illo unde earum consequuntur nemo repudiandae veritatis tempora laborum?</div>

                <div class="news-post__buttons">

                    <a href="<?= url('home', 'preview', ['id' => $post['id']]) ?>">
                        <span>Read More</span>
                    </a>

                </div>

            </div>

        </div>

        <div class="news-post">

            <div class="news-post__image"><img src="assets/images/wallpaperflare.com_wallpaper(1).jpg" alt=""></div>

            <div class="news-post__details">

                <div class="news-post__title"> Nothing </div>

                <div class="news-post__tags">
                    <span> <i class='bx bxs-purchase-tag'></i> <span> Something</span> <span> Nomething</span> </span>
                    <span> <i class='bx bxs-calendar'></i> <span>26-27-2032</span> </span>
                    <span> <i class='bx bx-time'></i> <span> 02:11:30 </span> </span>
                </div>

                <div class="news-post__description">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Maxime impedit neque ducimus aut quis expedita, ut at voluptatem laboriosam atque aliquid et veritatis sapiente? Quam deleniti nobis architecto magnam aliquid pariatur dolores exercitationem dolorem minus magni nulla, quisquam aperiam consequuntur impedit! Illo unde earum consequuntur nemo repudiandae veritatis tempora laborum?</div>

                <div class="news-post__buttons">

                    <a href="<?= url('home', 'preview', ['id' => $post['id']]) ?>">
                        <span>Read More</span>
                    </a>

                </div>

            </div>

        </div>

        <div class="news-post">

            <div class="news-post__image"><img src="assets/images/wallpaperflare.com_wallpaper(1).jpg" alt=""></div>

            <div class="news-post__details">

                <div class="news-post__title"> Nothing </div>

                <div class="news-post__tags">
                    <span> <i class='bx bxs-purchase-tag'></i> <span> Something</span> <span> Nomething</span> </span>
                    <span> <i class='bx bxs-calendar'></i> <span>26-27-2032</span> </span>
                    <span> <i class='bx bx-time'></i> <span> 02:11:30 </span> </span>
                </div>

                <div class="news-post__description">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Maxime impedit neque ducimus aut quis expedita, ut at voluptatem laboriosam atque aliquid et veritatis sapiente? Quam deleniti nobis architecto magnam aliquid pariatur dolores exercitationem dolorem minus magni nulla, quisquam aperiam consequuntur impedit! Illo unde earum consequuntur nemo repudiandae veritatis tempora laborum?</div>

                <div class="news-post__buttons">

                    <a href="<?= url('home', 'preview', ['id' => $post['id']]) ?>">
                        <span>Read More</span>
                    </a>

                </div>

            </div>

        </div>

        <div class="news-post">

            <div class="news-post__image"><img src="assets/images/wallpaperflare.com_wallpaper(1).jpg" alt=""></div>

            <div class="news-post__details">

                <div class="news-post__title"> Nothing </div>

                <div class="news-post__tags">
                    <span> <i class='bx bxs-purchase-tag'></i> <span> Something</span> <span> Nomething</span> </span>
                    <span> <i class='bx bxs-calendar'></i> <span>26-27-2032</span> </span>
                    <span> <i class='bx bx-time'></i> <span> 02:11:30 </span> </span>
                </div>

                <div class="news-post__description">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Maxime impedit neque ducimus aut quis expedita, ut at voluptatem laboriosam atque aliquid et veritatis sapiente? Quam deleniti nobis architecto magnam aliquid pariatur dolores exercitationem dolorem minus magni nulla, quisquam aperiam consequuntur impedit! Illo unde earum consequuntur nemo repudiandae veritatis tempora laborum?</div>

                <div class="news-post__buttons">

                    <a href="<?= url('home', 'preview', ['id' => $post['id']]) ?>">
                        <span>Read More</span>
                    </a>

                </div>

            </div>

        </div>





    </div>

</div>