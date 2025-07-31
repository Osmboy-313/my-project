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


?>