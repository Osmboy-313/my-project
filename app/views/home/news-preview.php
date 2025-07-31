<?php

// echo '<pre>';
// print_r($post);
// echo '</pre>';

$tags = explode(',', $post['post_tags']);
$dateAndTime = new DateTime($post['created_at']);

?>

<div class="news-page news-page--preview">


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

        <div class="news-post-preview__description"> <?= $post['post_description'] ?> Lorem ipsum dolor sit amet consectetur adipisicing elit. Earum consequatur accusamus veritatis numquam autem quae! Praesentium molestias ratione aut alias atque voluptas quia, inventore ullam impedit, consectetur similique. Repellat eaque totam esse vel? Beatae dolor voluptates adipisci assumenda dolorum officiis optio id molestias nostrum iure odit voluptas eligendi, nisi aspernatur ad. Nobis, eveniet. Odio illo repellat perferendis, itaque hic est maiores distinctio necessitatibus laborum beatae commodi laboriosam voluptatum quis blanditiis sint, id iusto omnis. Rem cumque aut quisquam repudiandae sequi blanditiis fugit atque sit, quas mollitia dolor facilis sunt praesentium corrupti a hic vero consectetur odio asperiores officiis vitae voluptatibus enim debitis. Beatae dolore magnam quidem quia, eligendi aut praesentium, eaque, sit totam atque dicta? Maxime sapiente repellat sit tempora, quam minima aliquam modi, accusamus incidunt placeat quidem libero delectus voluptate id vel animi dolor veritatis dignissimos deserunt voluptates error recusandae voluptatibus esse. Rem praesentium molestiae saepe perferendis laboriosam tempora modi recusandae eveniet nostrum dolorum maiores quas, unde quia, esse, eum ipsa inventore tenetur quidem. Ad laudantium magnam illo corrupti error obcaecati consectetur ipsam dicta esse soluta odit, consequuntur voluptatibus et minus adipisci beatae pariatur temporibus aspernatur. Tenetur at adipisci pariatur, quaerat quae rerum porro architecto expedita tempore, a sequi. </div>

    </div>


    <div class="news-page__list">

        <div class="news-page__heading--list">Recent Posts</div>



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