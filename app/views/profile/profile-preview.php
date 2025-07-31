<?php

session_start();

$title = "Profile";
ob_start();

?>
<div class="title"><span>Profile</span></div>

<div class="main-content profile-preview">

    <!-- <span>Welcome <?php echo $_SESSION['user']['user_type']?></span> -->
    <div class="profile-details">

        <div class="title">Profile Details</div>

        <div class="details">

            <div>
                <span class="column-name" >ID :</span>
                <span>1</span>
            </div>

            <div>
                <span class="column-name">Username :</span>
                <span>nothing</span>
            </div>

            <div>
                <span class="column-name">Email :</span>
                <span>nothing@gmail.com</span>
            </div>

            <div>
                <span class="column-name">Role :</span>
                <span>User</span>
            </div>

            <?php if($_SESSION['user']['user_type'] === 'boss'){?>

            <div class="buttons">
                <span class="column-name">Action :</span>
                <a href=""><span>Delete</span></a>
            </div>

            <?php } ?>

        </div>

    </div>

    <div class="post-title">Posts</div>

    <div class="alert"><span>No Posts Found!</span></div>


    <div class="post-container">

        <div class="actual-post">
      
            <div class="post">
                
                <div class="post-image">
                    <!-- <span>Image : </span> -->
                     <img src="../images/wallpaperflare.com_wallpaper(1).jpg" alt="">
                </div>

                <div class="post-content">

                    <div>
                    <span class="column-name" >Post Id : </span>
                    <span>1</span>
                    </div>

                    <div>
                        <span class="column-name">Post title :</span>
                        <span>HAllo du bist ein </span>
                    </div>

                    <div>
                    <span class="column-name">Post tag :</span>
                    <span>Php Laravel Something Nothing</span>
                    </div>

                    <div>
                    <span class="column-name">Post Category :</span>
                    <span>None</span>
                    </div>

                    <div>
                    <span class="column-name">Post description : </span>
                    <span>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Fugit eos nulla consectetur illo....</span>
                    </div>

                    <div class="buttons">
                        <a href="" class="preview-btn" ><span>View Full Post</span></a> 
                        <a href="" class="edit-btn" ><span>Edit</span></a> 
                        <a href="" class="del-btn" ><span>Delete</span></a>
                    </div>
                    
                </div>

            </div>

        </div>

        <div class="actual-post">

            <div class="post">
                
                <div class="post-image">
                    <!-- <span>Image : </span> -->
                     <img src="../images/wallpaperflare.com_wallpaper(1).jpg" alt="">
                </div>

                <div class="post-content">

                    <div>
                    <span class="column-name" >Post Id : </span>
                    <span>1</span>
                    </div>

                    <div>
                        <span class="column-name">Post title :</span>
                        <span>HAllo du bist ein </span>
                    </div>

                    <div>
                    <span class="column-name">Post tag :</span>
                    <span>Php Laravel Something Nothing</span>
                    </div>

                    <div>
                    <span class="column-name">Post Category :</span>
                    <span>None</span>
                    </div>

                    <div>
                    <span class="column-name">Post description : </span>
                    <span>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Fugit eos .</span>
                    </div>

                    <div class="buttons">
                        <a href="" class="preview-btn" ><span>View Full Post</span></a> 
                        <a href="" class="edit-btn" ><span>Edit</span></a> 
                        <a href="" class="del-btn" ><span>Delete</span></a>
                    </div>
                    
                </div>

            </div>

        </div>

        <!-- <div class="actual-post">

            <div class="post">
                
                <div class="post-image">
                     <img src="../images/wallpaperflare.com_wallpaper(1).jpg" alt="">
                </div>

                <div class="post-content">

                    <div>
                    <span class="column-name" >Post Id : </span>
                    <span>1</span>
                    </div>

                    <div>
                        <span class="column-name">Post title :</span>
                        <span>HAllo du bist ein </span>
                    </div>

                    <div>
                    <span class="column-name">Post tag :</span>
                    <span>Php Laravel Something Nothing</span>
                    </div>

                    <div>
                    <span class="column-name">Post Category :</span>
                    <span>None</span>
                    </div>

                    <div>
                    <span class="column-name">Post description : </span>
                    <span>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Fugit eos .</span>
                    </div>

                    <div class="buttons">
                        <a href="" class="preview-btn" ><span>View Full Post</span></a> 
                        <a href="" class="edit-btn" ><span>Edit</span></a> 
                        <a href="" class="del-btn" ><span>Delete</span></a>
                    </div>
                    
                </div>

            </div>

        </div> -->



    </div>

    <div class="pagination">

        <ul>
            <li> <a href=""> <i class='bx bx-chevron-left' ></i> </a> </li>
            <li class="active" > <a href=""> 1 </a> </li>
            <li> <a href=""> 2 </a> </li>
            <li> <a href=""> 3 </a> </li>
            <li> <a href=""> 4 </a> </li>
            <li> <a href=""> 5 </a> </li>
            <p>......</p>
            <li> <a href=""> 20 </a> </li>
            <li> <a href=""> <i class='bx bx-chevron-right'></i> </a> </li>
        </ul>

    </div>


</div>

<?php 

$content = ob_get_clean();
include BASE_PATH . '/layouts/post-login-pages-layout.php';

?>