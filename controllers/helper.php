<?php
session_start();
require_once __DIR__ . '/../config/db.php';
function GetErrorAttr(string $nameError)
{
	echo isset($_SESSION['validation'][$nameError]) ? 'is-invalid' : '';
}
function HasError(string $nameError) : bool
{
	return isset( $_SESSION['validation'][$nameError]);
}
function GetErrorMsg(string $nameError)
{
	echo $_SESSION['validation'][$nameError] ?? '';
}
function ClearValidation()
{
	$_SESSION['validation'] = [];
}
function GetProjects()
{
	 global $pdo;
      $stmt = $pdo->prepare('SELECT * FROM task_board WHERE user_id = ?');
    $stmt->execute([$_SESSION['user']['id']]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function GetSections(int $idProject)
{
    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM task_section WHERE task_board_id = ?');
    $stmt->execute([$idProject]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function GetTasks(int $idTask)
{
    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM task WHERE task_section_id = ?');
    $stmt->execute([$idTask]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function GetProject(int $idProject)
{
    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM task_board WHERE id = ?');
    $stmt->execute([$idProject]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function Logout()
{
	if($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		$_SESSION['user'] = [];
	}
	
	header("Location: /../pages/login.php");
}
?>