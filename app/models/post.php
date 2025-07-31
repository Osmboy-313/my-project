<?php 

require_once __DIR__ . '/../core/db.php';

function addPost($title , $tags , $description, $category, $img_O_name, $img_S_name){

    $conn = db();

    $id = $_SESSION['user']['id'];
    $sql = $conn->prepare('INSERT INTO `posts`(`post_title`, `post_tags`, `post_description`, `post_category`, `post_image`, `post_img_ori_name`, `user_id`) VALUES ( ? , ? , ? , ? , ? , ? , ? )');
    $sql->bind_param('sssissi', $title, $tags, $description, $category, $img_S_name , $img_O_name, $id);

    return $sql->execute();
}

function getUserPosts(){
    $conn = db();

    $id = $_SESSION['user']['id'];

    $sql = $conn->prepare("SELECT posts.*, categories.category_name FROM `posts` JOIN categories ON posts.post_category = categories.id WHERE posts.user_id = ?");
    $sql->bind_param('i',$id);
    $sql->execute();
    $result = $sql->get_result();

    return $result->fetch_all(MYSQLI_ASSOC);
}

function getPostById($id){
    $conn = db();

    $sql = $conn->prepare("SELECT posts.*, categories.category_name FROM `posts` JOIN categories ON posts.post_category = categories.id WHERE posts.id = $id");
    $sql->execute();
    $result = $sql->get_result();

    return $result->fetch_assoc();
}

function getAllPosts(){

    $conn = db();

    $sql = $conn->prepare("SELECT posts.*, categories.category_name FROM `posts` JOIN categories ON posts.post_category = categories.id");
    $sql->execute();
    $result = $sql->get_result();

    return $result->fetch_all(MYSQLI_ASSOC);

}


?>