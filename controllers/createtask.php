<?php
session_start();
require_once __DIR__ . '/../config/db.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(!isset($_SESSION['user'])){
       
        header("Location: /../pages/dashboard.php");
        exit();
    }

    $sectionId = trim($_POST['id']); 
    $taskName = trim($_POST['task-name']);
    $description = trim($_POST['task-description']);
    $completeDate = trim($_POST['complete-date']);

    
    if (empty($taskName) || empty($description) || empty($sectionId)) {
       
        header("Location: /../pages/dashboard.php");
        exit();
    } else {
        
        $stmt = $pdo->prepare("SELECT task_board_id FROM task_section WHERE id = ?");
        $stmt->execute([$sectionId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

       
        if ($result) {
            $taskBoardId = $result['task_board_id'];

            
            $stmt = $pdo->prepare("INSERT INTO task (name, description, task_section_id, task_board_id, complete_date) VALUES (?, ?, ?, ?, ?)");
            if ($stmt->execute([$taskName, $description, $sectionId, $taskBoardId, $completeDate])) {
                
               header("Location: /../pages/board.php?id=$taskBoardId");
                exit();
            } else {
                
                header("Location: /../pages/dashboard.php");
                exit();
            }
        } else {
            
            header("Location: /../pages/dashboard.php");
            exit();
        }
    }
}
?>
