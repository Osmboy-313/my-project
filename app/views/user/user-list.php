<?php

$title = "All User List";
ob_start();

?>



<div class="title"><span>List of All Normal Users</span></div>

<div class="main-content users">
    
    <div class="alert"><span>No Users Found!</span></div>

    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Username</th>
                <th>Email</th>
                <th>Profile</th>
            </tr>
        </thead>

        <tbody>

            
        </tbody>
            
    </table>

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
    
    <!--<td>
            <div class="buttons">
                <button class="edit-btn"><a href=""><span>Edit</span></a></button>
                <button class="del-btn"><a href=""><span>Delete</span></a></button>
            </div>
        </td> -->


<?php 

$content = ob_get_clean();
include BASE_PATH . '/layouts/post-login-pages-layout.php';

?>