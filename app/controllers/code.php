<?php

require_once __DIR__ . '/../models/user.php';
require_once __DIR__ . '/../models/post.php';
require_once __DIR__ . '/../models/code.php';
require_once __DIR__ .  '/../core/view.php';
require_once __DIR__ .  '/../core/auth.php';

function code_index()
{

    $activeTab = $_GET['tab'] ?? '#admin';
    $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $recordsPerPage = 2;
    $offset = ($currentPage - 1) * $recordsPerPage;

    $adminCodes = $bossCodes = [];
    $totalRecords = $totalPages = 1;

    switch ($activeTab) {
        case '#boss':
            $totalRecords = countBossCodes();
            $bossCodes = getBosscodes($recordsPerPage, $offset);
            break;
        default:
            $totalRecords = countAdminCodes();
            $adminCodes = getAdmincodes($recordsPerPage, $offset);
            break;
    }

    $totalPages = max(1, ceil($totalRecords / $recordsPerPage));

    $serialNumber = $offset + 1;

    $start = $offset + 1;
    $end = $offset + $recordsPerPage;
    $end = min($end, $totalRecords);

    
    if (isset($_GET['ajax']) && $_GET['ajax'] == '1') {

        // Render only the partial view and exit
        echo view('codes/tabs', [
            'activeTab' => $activeTab,
            'adminCodes' => $adminCodes,
            'bossCodes' => $bossCodes,
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
    
    
    
    $modals = view('codes/code-modals', ['activeTab' => $activeTab]);
    echo view(
        'codes/code',
        [
            'title' => 'Codes',
            'modals' => $modals,
            'activeTab' => $activeTab,
            'adminCodes' => $adminCodes,
            'bossCodes' => $bossCodes,
            'totalRecords' => $totalRecords,
        ],
        'private'
    );


}
