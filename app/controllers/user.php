<?php

require_once __DIR__ . '/../models/user.php';
require_once __DIR__ . '/../models/post.php';
require_once __DIR__ . '/../models/category.php';
require_once __DIR__ .  '/../core/view.php';
require_once __DIR__ .  '/../core/auth.php';

function user_index(){

    // $activeTab = $_GET['tab'] ?? '#user';
    // $currentPage = $_GET['page'] ?? 1;

    // $recordsPerPage = 3;

    // $userTotalRecords = getAccountsCount('user'); 
    // $adminTotalRecords = getAccountsCount('admin'); 
    // $bossTotalRecords = getAccountsCount('boss'); 

    // $userTotalPages   = (int)ceil($userTotalRecords / $recordsPerPage);
    // $adminTotalPages   = (int)ceil($adminTotalRecords / $recordsPerPage);
    // $bossTotalPages   = (int)ceil($bossTotalRecords / $recordsPerPage);

    // // ensure currentPage is in [1..totalPages]
    // if ($currentPage < 1)        $currentPage = 1;
    // elseif ($currentPage > $userTotalPages) $currentPage = $userTotalPages;

    // // 4) calculate offset
    // $offset = ($currentPage - 1) * $recordsPerPage;

    // // 5) fetch 

    // $users = getAccountsPaginated('user',$recordsPerPage,$offset);
    // $admins = getAccountsPaginated('admin',$recordsPerPage,$offset);
    // $bosses = getAccountsPaginated('boss',$recordsPerPage,$offset);

    // // $users = getUsers();
    // // $admins = getAdmins();
    // // $bosses = getBosses();

    $activeTab = $_GET['tab'] ?? '#user';
    $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $recordsPerPage = 5;
    $offset = ($currentPage - 1) * $recordsPerPage;

    // Count & fetch for the active tab (like before)
    $users = $admins = $bosses = [];
    $totalRecords = $totalPages = 1;
    switch ($activeTab) {
        case '#admin':
            $totalRecords = getAccountsCount('admin');
            $admins = getAccountsPaginated('admin', $recordsPerPage, $offset);
            break;
        case '#boss':
            $totalRecords = getAccountsCount('boss');
            $bosses = getAccountsPaginated('boss', $recordsPerPage, $offset);
            break;
        default:
            $totalRecords = getAccountsCount('user');
            $users = getAccountsPaginated('user', $recordsPerPage, $offset);
            break;
    }
    $totalPages = max(1, ceil($totalRecords / $recordsPerPage));

    $serialNumber = $offset + 1;

    $start = $offset + 1;
    $end = $offset + $recordsPerPage;
    $end = min($end, $totalRecords);

    if (isset($_GET['ajax']) && $_GET['ajax'] == '1') {
        // Render only the partial view and exit
        echo view('user/tabs', [
            'users' => $users,
            'admins' => $admins,
            'bosses' => $bosses,
            'activeTab' => $activeTab,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'totalRecords' => $totalRecords,
            'recordsPerPage' => $recordsPerPage,
            'serialNumber' => $serialNumber,
            'start' => $start,
            'end' => $end,
        ],);
        exit;
    }


    echo view('user/user-list', ['title' => 'users', 'activeTab' => $activeTab], 'private');
}


?>