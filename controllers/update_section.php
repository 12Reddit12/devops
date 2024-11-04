<?php
session_start();

require_once __DIR__ . '/../config/db.php';



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(!isset($_SESSION['user'])){
    //header("Location: /../pages/dashboard.php");
    exit();
    }
       $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $boardname = trim($_POST['section-name']);
    $description = trim($_POST['description']);

    
    if (empty($boardname) || empty($description)) {
        header("Location: /../pages/dashboard.php");
        exit();
    } else {
         
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$_SESSION['user']['username']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            
                
                $stmt = $pdo->prepare("UPDATE task_section SET name = ?, description = ? WHERE id = ?");
                $result = $stmt->execute([$boardname, $description, $id]);

                if ($result) {
                   header("Location: /../pages/dashboard.php");
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
