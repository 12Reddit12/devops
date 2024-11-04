<?php
session_start();
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

     $taskId = $_POST['id'];
    $isCompleted = $_POST['isCompleted'];
    

    
    if (!isset($_SESSION['user'])) {
        echo json_encode(['success' => false, 'message' => 'User not authorized']);
        exit();
    }

 
  
        
        $updateStmt = $pdo->prepare('UPDATE task SET is_completed = ? WHERE id = ?');
        if ($updateStmt->execute([$isCompleted, $taskId])) {
            //echo json_encode(['success' => true]);
        } else {
           // echo json_encode(['success' => false, 'message' => 'Failed to update task status']);
        }

}
?>
