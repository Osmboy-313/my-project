<?php

$title = "Categories";
ob_start();

?>



<div class="title">
    <span>Codes</span> 
    <button type="button" data-modal-target="#modal"><a href="" class="add-category" ><span>Add Codes</span></a></button>
</div>

<div class="main-content categories">

    <div class="alert"><span>No Category Found!</span></div>

    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Admin Code</th>
                <th>Boss Code</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>1</td>
                <td>Nothing</td>
                <td>Nothing</td>
                <td class="action">
                    <div class="buttons">
                    <button type="button" data-modal-target="#edit-modal" class="edit-btn"><span>Edit</span></button>
                    <button type="button" data-modal-target="#del-modal" class="del-btn"><span>Delete</span></button>
                    </div>
                </td>
            </tr>
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

<?php 

// include __DIR__ . '/category-modals.php';

?>



<?php 

$content = ob_get_clean();

// buffer modals separately
ob_start();
include __DIR__ . '/code-modals.php';
$modals = ob_get_clean();

include BASE_PATH . '/layouts/post-login-pages-layout.php';


?>