
<?php 

$recordsPerPage = 3;

$currentPage = isset($_GET['page']) ? (int) $_GET['page'] : 1 ;
$currentPage = max(1, $currentPage);

$totalRecords = count($posts);
$totalPages = max(1,ceil($totalRecords/$recordsPerPage)) ;

$currentPage = min($currentPage, $totalPages);

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

        <?php foreach($posts as $post):?>

        <div class="actual-post">

            <div class="post">

                <div class="post-image">
                    <img src="<?= 'assets/uploads/permanent/' . $post['post_image'] ?>" alt="">
                </div>

                <div class="post-content">

                    <div>
                        <span class="column-name"> Sr no : </span>
                        <span>1</span>
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
                        
                        <a href=" <?= url('home', 'preview', ['id' => $post['id']] )?> " class="preview-btn">
                            <span>View Full Post</span>
                        </a>

                        <a href=" <?= url('post', 'edit', ['id' => $post['id']] )?> " class="edit-btn"> <span>Edit</span> </a>
                        <a data-modal-target="#del-modal" class="del-btn"><span>Delete</span></a>
                    </div>

                </div>

            </div>

        </div>

        <?php endforeach?>

        <div class="actual-post">

            <div class="post">

                <div class="post-image">
                    <img src="<?= 'assets/uploads/permanent/' . $post['post_image'] ?>" alt="">
                </div>

                <div class="post-content">

                    <div>
                        <span class="column-name"> Sr no : </span>
                        <span>1</span>
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
                        
                        <a href=" <?= url('home', 'preview', ['id' => $post['id']] )?> " class="preview-btn">
                            <span>View Full Post</span>
                        </a>

                        <a href=" <?= url('post', 'edit', ['id' => $post['id']] )?> " class="edit-btn"> <span>Edit</span> </a>
                        <a data-modal-target="#del-modal" class="del-btn"><span>Delete</span></a>
                    </div>

                </div>

            </div>

        </div>

        <div class="actual-post">

            <div class="post">

                <div class="post-image">
                    <img src="<?= 'assets/uploads/permanent/' . $post['post_image'] ?>" alt="">
                </div>

                <div class="post-content">

                    <div>
                        <span class="column-name"> Sr no : </span>
                        <span>1</span>
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
                        
                        <a href=" <?= url('home', 'preview', ['id' => $post['id']] )?> " class="preview-btn">
                            <span>View Full Post</span>
                        </a>

                        <a href=" <?= url('post', 'edit', ['id' => $post['id']] )?> " class="edit-btn"> <span>Edit</span> </a>
                        <a data-modal-target="#del-modal" class="del-btn"><span>Delete</span></a>
                    </div>

                </div>

            </div>

        </div>

        


    </div>

    <div class="pagination <?= empty($posts) ? 'de-active' : '' ?>">

        <div class="pagination__wrapper">

            <div class="dummy__div">Hallo</div>

            <div class="pagination__controls">

                <ul>
                    <li> <a href=""> <i class='bx bx-chevron-left'></i> </a> </li>
                    <li class="active"> <a href=""> 1 </a> </li>
                    <li> <a href=""> 2 </a> </li>
                    <li> <a href=""> 3 </a> </li>
                    <li> <a href=""> 4 </a> </li>
                    <li> <a href=""> 5 </a> </li>
                    <p>......</p>
                    <li> <a href=""> 20 </a> </li>
                    <li> <a href=""> <i class='bx bx-chevron-right'></i> </a> </li>
                </ul>

            </div>

            <div class="pagination__summary">

                <p> Showing 0 - 0 of 50 </p>

            </div>

        </div>

    </div>

</div>