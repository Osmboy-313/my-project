<?php 

require_once __DIR__ . '/../core/db.php';

function check_user_exists($detail = []){

    if (!isset($detail['column'], $detail['value'])) {
        return 'Missing column or value';
    }

    $column = $detail['column'];
    $value = $detail['value'];
    $allowed_columns = ['id', 'email', 'username'];

    if (!in_array($column, $allowed_columns)) {
        return 'Invalid column name';
    }

    $conn = db();
    $sql = $conn->prepare("SELECT * FROM `users` WHERE `$column` = ? ");
    $sql->bind_param('s', $value );
    $sql->execute();
    $result = $sql->get_result();

    return $result->fetch_all(MYSQLI_ASSOC);
}

function get_user_pass($email, $userType){
    $conn = db();

    $sql = $conn->prepare("SELECT * FROM `users` WHERE `email` = ? AND `user_type` = ? ");
    $sql->bind_param('ss', $email, $userType);
    $sql->execute();
    $result = $sql->get_result();

    return $result->fetch_assoc();
}

function addUser($username, $email, $userType, $password){
    $conn = db();
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = $conn->prepare("INSERT INTO `users` (`username`, `email`, `user_type`, `password`) VALUES ( ? , ? , ? , ? ) ");
    $sql->bind_param('ssss', $username, $email, $userType, $hashedPassword);
    return $sql->execute();
    
}

function getUsers(){
    $conn = db();

    $userType = 'user';
    $sql = $conn->prepare("SELECT * FROM `users` WHERE `user_type` = ? ");
    $sql->bind_param('s', $userType);
    $sql->execute();
    $result = $sql->get_result();

    return $result->fetch_all(MYSQLI_ASSOC);
}

function getAdmins(){
    $conn = db();

    $userType = 'admin';
    $sql = $conn->prepare("SELECT * FROM `users` WHERE `user_type` = ? ");
    $sql->bind_param('s', $userType);
    $sql->execute();
    $result = $sql->get_result();

    return $result->fetch_all(MYSQLI_ASSOC);
}

function getBosses(){
    $conn = db();

    $userType = 'boss';
    $sql = $conn->prepare("SELECT * FROM `users` WHERE `user_type` = ? ");
    $sql->bind_param('s', $userType);
    $sql->execute();
    $result = $sql->get_result();

    return $result->fetch_all(MYSQLI_ASSOC);
}



function getAccountsPaginated($userType, $limit, $offset) {
    $conn = db();

    $sql = $conn->prepare("SELECT * FROM users WHERE user_type = ? LIMIT ? OFFSET ?");
    $sql->bind_param('sii', $userType, $limit, $offset);
    $sql->execute();
    $result = $sql->get_result();

    return $result->fetch_all(MYSQLI_ASSOC);
}

function getAccountsCount($userType) {
    $conn = db();

    $sql = $conn->prepare("SELECT COUNT(*) as total FROM users WHERE user_type = ?");
    $sql->bind_param('s', $userType);
    $sql->execute();
    $result = $sql->get_result()->fetch_assoc();

    return $result['total'];
}




function getUserWithPosts($id, $recordsPerPage, $offset){
    $conn = db();

    $userStmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $userStmt->bind_param('i', $id);
    $userStmt->execute();
    $userResult = $userStmt->get_result();
    $user = $userResult->fetch_assoc();

    if (!$user) return null;

    // Now, get the posts
    $postStmt = $conn->prepare("SELECT * FROM posts WHERE post_user = ? LIMIT ? OFFSET ? ");
    $postStmt->bind_param('iii', $id, $recordsPerPage,$offset);
    $postStmt->execute();
    $postResult = $postStmt->get_result();
    $posts = $postResult->fetch_all(MYSQLI_ASSOC);

    return [
        'user' => $user,
        'posts' => $posts
    ];
}


?>