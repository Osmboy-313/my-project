<?php 

require_once __DIR__ . '/../core/db.php';

function fetch_codes(){
    $conn = db();
    $sql = $conn->prepare("SELECT * FROM `codes`");
    $sql->execute();
    $result = $sql->get_result();

    if($result && $result->num_rows > 0){
        return $result->fetch_all(MYSQLI_ASSOC);
    }else{
        return [] ;
    }
}

?>