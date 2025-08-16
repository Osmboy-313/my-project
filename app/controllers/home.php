<?php 

require_once __DIR__ .  '/../models/post.php';
require_once __DIR__ .  '/../core/view.php';
require_once __DIR__ .  '/../core/auth.php';

function home_index(){
  // Get search query from URL
  $searchQuery = $_GET['search'] ?? '';
  $posts = [];
  
  if (!empty($searchQuery)) {
    // Search posts if query exists
    $posts = searchPosts($searchQuery);
  } else {
    // Get all posts if no search
    $posts = getAllPosts();
  }
  
  echo view('/home/index', ['title' => 'Home', 'posts' => $posts, 'searchQuery' => $searchQuery], 'public');
}

function home_preview(){

  $postId = $_GET['id'] ?? 0;
  $post = getPostById($postId);
  $latestPosts = getLatestPosts(10, $postId);

  echo view('/home/news-preview' ,['title' => 'Preview', 'post' => $post, 'latestPosts' => $latestPosts], 'public');
}

?>