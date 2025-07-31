<?php

function url($c,$a,$extra = []){

    $query = http_build_query(array_merge(['c' => $c, 'a' => $a ], $extra));

    return "index.php?{$query}";

}

function active( string $c , ?string $a = null){

    $controller = $_GET['c'] ?? 'home';
    $action = $_GET['a'] ?? 'index';

    return ($c === $controller && ($a === null || $a === $action)) ? 'active' : '';

}

function unsetTempSession($c,$a){
    if($c === 'post' && $a !== 'add'){
        if(isset($_SESSION['temp-upload'])){
            unlink($_SESSION['temp-upload']['file-temp-path']);
            unset($_SESSION['temp-upload']);
        }
    }

    else if($c !== 'post'){
        if(isset($_SESSION['temp-upload'])){
            unlink($_SESSION['temp-upload']['file-temp-path']);
            unset($_SESSION['temp-upload']);
        }
    }
}

?>