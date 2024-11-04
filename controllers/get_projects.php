<?php
session_start();
require_once __DIR__ . '/../config/db.php';

header('Content-Type: application/json');

function GetProjects()
{
    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM task_board WHERE user_id = ?');
    $stmt->execute([$_SESSION['user']['id']]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$projects = GetProjects();
echo json_encode($projects);
?>
