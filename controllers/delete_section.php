<?php
session_start();
require_once __DIR__ . '/../config/db.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['user'])) {
        header("Location: /../pages/dashboard.php");
        exit();
    }

   
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

   
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$_SESSION['user']['username']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {

       
            
            $stmt = $pdo->prepare("DELETE FROM task_section WHERE id = ?");
            $result = $stmt->execute([$id]);

            if ($result) {
               
            } else {
               
            }
        } else {
            
        }

}
?>
