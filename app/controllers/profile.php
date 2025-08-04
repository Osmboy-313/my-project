<?php

require_once __DIR__ . '/../models/user.php';
require_once __DIR__ . '/../models/post.php';
require_once __DIR__ . '/../models/category.php';
require_once __DIR__ .  '/../core/view.php';
require_once __DIR__ .  '/../core/auth.php';

function profile_myProfile(){


}

function profile_preview(){

    $userId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

    $recordsPerPage = 2;

    $currentPage = isset($_GET['page']) ? (int)$_GET['page']: 1;
    $totalRecords = countAllPosts(); 
    $totalPages   = (int)ceil($totalRecords / $recordsPerPage);

    if ($currentPage < 1)        $currentPage = 1;
    elseif ($currentPage > $totalPages) $currentPage = $totalPages;

    $offset = ($currentPage - 1) * $recordsPerPage;
    
    $userProfile = getUserWithPosts($userId, $recordsPerPage, $offset);
    $user = $userProfile['user'];
    $posts = $userProfile['posts'];

    // $posts = getAllPosts();

    $start = $offset + 1;
    $end = $offset + $recordsPerPage;
    $end = min($end, $totalRecords);

    echo view('profile/profile-preview', [
        'title' => 'User Profile',
        'user' => $user,
        'posts' => $posts,
        'currentPage' => $currentPage,
        'totalPages' => $totalPages,
        'totalRecords' => $totalRecords,
        'start' => $start,
        'end' => $end,
        ],
        'private');

}

?>