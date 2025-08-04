<?php

require_once __DIR__ . '/../core/db.php';

function fetch_codes()
{
    $conn = db();
    $sql = $conn->prepare("SELECT * FROM `codes`");
    $sql->execute();
    $result = $sql->get_result();

    if ($result && $result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return [];
    }
}

function getAdmincodes($recordsPerPage, $offset)
{
    $conn = db();
    $sql = $conn->prepare("SELECT id, admin_code FROM codes WHERE admin_code IS NOT NULL ORDER BY id ASC  LIMIT ? OFFSET ?");
    $sql->bind_param('ii', $recordsPerPage, $offset);
    $sql->execute();
    $result = $sql->get_result();

    return $result->fetch_all(MYSQLI_ASSOC);
}


function getBosscodes($recordsPerPage, $offset)
{
    $conn = db();
    $sql = $conn->prepare("SELECT id, boss_code FROM codes WHERE boss_code IS NOT NULL ORDER BY id ASC  LIMIT ? OFFSET ?");
    $sql->bind_param('ii', $recordsPerPage, $offset);
    $sql->execute();
    $result = $sql->get_result();

    return $result->fetch_all(MYSQLI_ASSOC);
}

function countAdminCodes()
{
    $conn = db();
    $result = $conn->query("SELECT COUNT(*) AS total FROM codes WHERE admin_code IS NOT NULL");
    return $result->fetch_assoc()['total'];
}

function countBossCodes()
{
    $conn = db();
    $result = $conn->query("SELECT COUNT(*) AS total FROM codes WHERE boss_code IS NOT NULL");
    return $result->fetch_assoc()['total'];
}


