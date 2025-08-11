<?php

require_once __DIR__ . '/../models/user.php';
require_once __DIR__ . '/../models/post.php';
require_once __DIR__ . '/../models/category.php';
require_once __DIR__ .  '/../core/view.php';
require_once __DIR__ .  '/../core/auth.php';

function profile_myProfile(){

    echo view('profile/my-profile', ['title' => 'My Profile'], 'private');
}

function profile_get(){

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $id = $_SESSION['user']['id'];
        $user = getUserById($id);
        echo json_encode($user);
    }
    
}

function profile_preview(){

    $userId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

    $recordsPerPage = 4;

    $currentPage = isset($_GET['page']) ? (int)$_GET['page']: 1;
    $totalRecords = countAllPaginatedPosts($userId); 
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

    $modals = view('components/modals');

    echo view('profile/profile-preview', [
        'title' => 'User Profile',
        'user' => $user,
        'posts' => $posts,
        'currentPage' => $currentPage,
        'totalPages' => $totalPages,
        'totalRecords' => $totalRecords,
        'start' => $start,
        'end' => $end,
        'modals' => $modals,
        ],
        'private');

}

?>