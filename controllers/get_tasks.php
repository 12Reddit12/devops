<?php
session_start();
require_once __DIR__ . '/../config/db.php';

header('Content-Type: application/json');

function GetTasks()
{
    global $pdo;
    $stmt = $pdo->query('SELECT * FROM task');
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$projects = GetTasks();
echo json_encode($projects);
?>
