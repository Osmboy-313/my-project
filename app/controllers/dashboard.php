<?php

require_once __DIR__ .  '/../core/view.php';
require_once __DIR__ .  '/../core/auth.php';

function dashboard_index(){
    echo view('/dashboard/index', ['title' => 'Dashboard'], 'private');
}


?>