<?php
session_start();
require_once __DIR__ . '/../config/db.php';

header('Content-Type: application/json');

function GetSectionss()
{
    global $pdo;
    $stmt = $pdo->query('SELECT * FROM task_section');
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$sectionss = GetSectionss();
echo json_encode($sectionss);
?>
