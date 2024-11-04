<?php
session_start();

require_once __DIR__ . '/../config/db.php';



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(!isset($_SESSION['user'])){
    //header("Location: /../pages/dashboard.php");
    exit();
    }
    $boardid = trim($_POST['id']);
    $boardname = trim($_POST['board-name']);
    $description = trim($_POST['description']);

    
    if (empty($boardname) || empty($description)) {
        header("Location: /../pages/dashboard.php");
        exit();
    } else {
        
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$_SESSION['user']['username']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user ) {
            $stmt = $pdo->prepare("INSERT INTO task_section (name, description,task_board_id) VALUES (?, ?, ?)");
            if ($stmt->execute([$boardname, $description, $boardid])) {
                header("Location: /../pages/board.php?id=$boardid");
                exit();
            }
            header("Location: /../pages/dashboard.php");
            exit();
        } else {
            header("Location: /../pages/dashboard.php");
            exit();
        }
    }
    

}
?>
