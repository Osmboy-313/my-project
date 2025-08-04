<?php

require_once __DIR__ . '/../core/db.php';

function addPost($title, $tags, $description, $category, $img_O_name, $img_S_name)
{

    $conn = db();

    $id = $_SESSION['user']['id'];
    $sql = $conn->prepare('INSERT INTO `posts`(`post_title`, `post_tags`, `post_description`, `post_category`, `post_image`, `post_img_original_name`, `post_user`) VALUES ( ? , ? , ? , ? , ? , ? , ? )');
    $sql->bind_param('sssissi', $title, $tags, $description, $category, $img_S_name, $img_O_name, $id);

    return $sql->execute();
}

function updatePost($id, $title, $tags, $description, $category, $img_O_name, $img_S_name)
{

    $conn = db();

    $sql = $conn->prepare('UPDATE `posts` SET `post_title`= ? ,`post_tags`= ? ,`post_description`= ? ,`post_category`= ? ,`post_image`= ? ,`post_img_original_name`= ?  WHERE `id` = ? ');
    $sql->bind_param('sssissi', $title, $tags, $description, $category, $img_S_name, $img_O_name, $id);

    return $sql->execute();
}

function getUserPaginatedPosts($recordsPerPage, $offset)
{
    $conn = db();

    $id = $_SESSION['user']['id'];

    $sql = $conn->prepare("SELECT posts.*, categories.category_name FROM `posts` JOIN categories ON posts.post_category = categories.id WHERE posts.post_user = ? LIMIT ? OFFSET ? ");
    $sql->bind_param('iii', $id, $recordsPerPage,  $offset);
    $sql->execute();
    $result = $sql->get_result();

    return $result->fetch_all(MYSQLI_ASSOC);
}

function countUserPosts() {
    $conn = db();
    $id = $_SESSION['user']['id'];
    $stmt = $conn->prepare("SELECT COUNT(*) AS cnt FROM posts WHERE post_user = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    return (int)$res['cnt'];
}

function getPostById($id)
{
    $conn = db();

    $sql = $conn->prepare("SELECT posts.*, categories.category_name FROM `posts` JOIN categories ON posts.post_category = categories.id WHERE posts.id = $id");
    $sql->execute();
    $result = $sql->get_result();

    return $result->fetch_assoc();
}

function getAllPosts()
{

    $conn = db();

    $sql = $conn->prepare("SELECT 
        posts.*,
        users.id AS user_id,
        users.username AS username,
        categories.id AS category_id,
        categories.category_name AS category_name
    FROM posts
    JOIN users ON posts.post_user = users.id
    JOIN categories ON posts.post_category = categories.id
    ORDER BY posts.created_at DESC");

    $sql->execute();
    $result = $sql->get_result();

    return $result->fetch_all(MYSQLI_ASSOC);
}

function getAllPaginatedPosts($recordsPerPage, $offset){

    $conn = db();

    $sql = $conn->prepare("SELECT 
        posts.*,
        users.id AS user_id,
        users.username AS username,
        categories.id AS category_id,
        categories.category_name AS category_name
    FROM posts
    JOIN users ON posts.post_user = users.id
    JOIN categories ON posts.post_category = categories.id
    ORDER BY posts.created_at DESC LIMIT ? OFFSET ?");

    $sql->bind_param('ii',$recordsPerPage, $offset);
    $sql->execute();
    $result = $sql->get_result();

    return $result->fetch_all(MYSQLI_ASSOC);
}

function countAllPosts() {
    $conn = db();

    $sql = $conn->prepare("SELECT COUNT(*) AS total FROM posts");
    $sql->execute();
    $result = $sql->get_result();

    return $result->fetch_assoc()['total'];
}

function getPostsByCategoryId($id)
{

    $conn = db();

    $sql = $conn->prepare('SELECT `post_image` FROM `posts` WHERE `post_category` = ?');
    $sql->bind_param('i', $id);
    $sql->execute();
    $result = $sql->get_result();

    return $result->fetch_all(MYSQLI_ASSOC);
}

function deletePostsByCategory($id): bool
{
    $conn = db();
    $sql = $conn->prepare("DELETE FROM posts WHERE post_category = ?");
    $sql->bind_param('i', $id);

    return $sql->execute();
}

function getLatestPosts($limit, $excludeId)
{
    $conn = db();

    $sql = $conn->prepare("SELECT posts.*, categories.category_name FROM posts JOIN categories ON posts.post_category = categories.id WHERE posts.id != ? ORDER BY posts.created_at DESC LIMIT ?");
    $sql->bind_param('ii', $excludeId, $limit);
    $sql->execute();
    $result = $sql->get_result();

    return $result->fetch_all(MYSQLI_ASSOC);
}

function getAllPostsWithUser() {}
