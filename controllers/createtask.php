<?php
session_start();
require_once __DIR__ . '/../config/db.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(!isset($_SESSION['user'])){
        echo json_encode(["error" => "1"]);
        header("Location: /../pages/login.php");
        exit();
    }

    $sectionId = trim($_POST['id']); 
    $taskName = trim($_POST['task-name']);
    $description = trim($_POST['task-description']);
    $completeDate = trim($_POST['complete-date']);

    
    if (empty($taskName) || empty($description) || empty($sectionId)) {
       echo json_encode(["error" => "2"]);
        header("Location: /../pages/dashboard.php");
        exit();
    } else {
        
        $stmt = $pdo->prepare("SELECT task_board_id FROM task_section WHERE id = ?");
        $stmt->execute([$sectionId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

       echo json_encode(["error" => "3"]);
        if ($result) {
            $taskBoardId = $result['task_board_id'];

            
            $stmt = $pdo->prepare("INSERT INTO task (name, description, task_section_id, task_board_id, complete_date) VALUES (?, ?, ?, ?, ?)");
            if ($stmt->execute([$taskName, $description, $sectionId, $taskBoardId, $completeDate])) {
                echo json_encode(["error" => "4"]);
               header("Location: /../pages/board.php?id=$taskBoardId");
                exit();
            } else {
                echo json_encode(["error" => "5"]);
                header("Location: /../pages/dashboard.php");
                exit();
            }
        } else {
            echo json_encode(["error" => "6"]);
            header("Location: /../pages/dashboard.php");
            exit();
        }
    }
}
?>
