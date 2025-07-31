<?php 

require_once __DIR__ .  '/../models/post.php';
require_once __DIR__ .  '/../core/view.php';
require_once __DIR__ .  '/../core/auth.php';

function home_index(){
  $posts = getAllPosts();
  echo view('/home/index', ['title' => 'Home', 'posts' => $posts], 'public');
}

function home_preview(){
  $postId = $_GET['id'] ?? 0;
  $post = getPostById($postId);
   echo view('/home/news-preview' ,['title' => 'Preview', 'post' => $post], 'public');
}

?>