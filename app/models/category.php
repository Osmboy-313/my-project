<?php 

require_once __DIR__ . '/../core/db.php';

function addCategory($name){
    $conn = db();

    $id = $_SESSION['user']['id'];
    $sql = $conn->prepare("INSERT INTO `categories`( `category_name`, `user_id`) VALUES ( ? , ?)");
    $sql->bind_param('si',$name,$id);

    return $sql->execute();
}

function getAllCategories(){
    $conn = db();

    $id = $_SESSION['user']['id'];
    $sql = $conn->prepare('SELECT * FROM `categories` WHERE `user_id` = ? ');
    $sql->bind_param('s', $id);
    $sql->execute();
    $result = $sql->get_result();

    return $result->fetch_all(MYSQLI_ASSOC);
}

function getSingleCategory($id){
    $conn = db();

    $sql = $conn->prepare("SELECT * FROM `categories` WHERE `id` = ? ");
    $sql->bind_param('i' , $id);
    $sql->execute();
    $result = $sql->get_result();

    return $result->fetch_assoc();
}

function categoryExistenceCheck($name, $idToExclude = 0){
    $conn = db();
    
    $userId = $_SESSION['user']['id'];
    $sql = $conn->prepare("SELECT * FROM `categories` WHERE `user_id` = ? AND `category_name` = ? AND `id` != ? ");
    $sql->bind_param('isi' , $userId, $name, $idToExclude);
    $sql->execute();
    $result = $sql->get_result();

    return $result->fetch_all(MYSQLI_ASSOC);
}

function editCategory($id, $name){
    $conn = db();
    
    $sql = $conn->prepare("UPDATE `categories` SET `category_name`= ? WHERE `id` = ? ");
    $sql->bind_param('si' , $name, $id );
    
    return $sql->execute();
}

function deleteCategory($id){
    $conn = db();

    $sql = $conn->prepare('DELETE FROM `categories` WHERE `id` = ? ') ;
    $sql->bind_param('i', $id);

    return $sql->execute();

}


?>