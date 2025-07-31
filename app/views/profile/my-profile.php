<?php

session_start();

$title = "My Profile";
ob_start();

?>
<div class="title"><span>My Profile</span></div>

<div class="main-content my-profile">

    <!-- <span>Welcome <?php // echo $_SESSION['user']['user_type']?></span> -->

    <div class="profile">

        <div class="title1">Profile Details</div>

        <form action="" class="update-details">

            <div class="input-box">
                <label for="">Username</label>
                <input type="text" name="" id="username" placeholder="Enter your username">
                <span class="error-box">Enter your username</span>

            </div>

            <div class="input-box" >
                <label for="">Email</label>
                <input type="email" name="" id="email" placeholder="Enter your email">
                <span class="error-box"></span>
            </div>

            <input type="submit" value="Update Details" class="submit-btn">


        </form>

        <div class="title2">Role</div>

            <form action="" class="update-details" id="role-update-form" >

                <div class="input-box">
                
                    <label for="">Role</label>

                    <div class="select-wrapper">
                        <select name="" id="user-type-select">
                            <option value="" selected disabled>Select an option</option>
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                            <option value="boss">Boss</option>
                        </select>
                        <i class='bx bx-chevron-down' ></i>
                    </div>

                    <span class="error-box"></span>

                </div>

                <div class="input-box hidden" id="code-box">
                    <label for="">Admin</label>
                    <input type="text" name="" id="code" placeholder="Enter admin code">
                    <span class="error-box"></span>
                </div>

                <input type="submit" value="Update Role" class="submit-btn">

            </form>


        <div class="title2">Password</div>

        <form action="" class="update-pass" >

            <div class="input-box current-pass">
                <label for="">Current Password</label>
                <input type="password" name="" id="" placeholder="Enter your current password">
                <span class="error-box"></span>

            </div>

            <div class="input-box" >
                <label for="">New Password</label>
                <input type="password" name="" id="" placeholder="Enter your new password">
                <span class="error-box"></span>

            </div>

            <div class="input-box" >
                <label for="">Confirm Password</label>
                <input type="password" name="" id="" placeholder="Confirm new password">
                <span class="error-box"></span>

            </div>

            <input type="submit" value="Update Password" class="submit-btn pass" >


        </form>

    </div>

    <div class="profile-picture">

        <div class="title">Profile Details</div>

        <!-- <img src="<?= BASE_PATH . '/images/wallpaperflare.com_wallpaper(1).jpg' ?>" alt=""> -->
        <img src="../images/wallpaperflare.com_wallpaper(1).jpg" alt="">
        
        <form action="">

            <div class="input-box" >
                <label for="Post Picture">Post Picture</label>
                <div class="custom-file-upload" id="custom-file-upload">
                    <input type="file" hidden class="file-upload-input" id="file-upload-input" >
                    <button type="button" class="file-upload-btn" id="file-upload-btn">Browse ...</button>
                    <span class="file-upload-msg" id="file-upload-msg">No File Selected</span>
                </div>
            </div>

            <input type="submit" value="Update Picture" class="submit-btn" >

        </form>

    </div>


</div>

<?php 

$content = ob_get_clean();
include BASE_PATH . '/layouts/post-login-pages-layout.php';

?>