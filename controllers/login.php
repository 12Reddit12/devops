<?php
session_start();
if(isset($_SESSION['user'])){
    header("Location: /../pages/dashboard.php");
    exit();
}
require_once __DIR__ . '/../config/db.php';

$_SESSION['validation'] = [];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    
    if (empty($username) || empty($password)) {
        $_SESSION['validation']['error'] = "Логін та пароль повинні бути заповнені!";
        header("Location: /../pages/login.php");
        exit();
    } else {
        
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            
            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'avatar' => $user['avatar'] ?? null
            ];
             $_SESSION['validation']['error'] = "Успішна авторизація!";
            header("Location: /../pages/dashboard.php"); 
            exit();
        } else {
            $_SESSION['validation']['error'] = "Невірний логін або пароль!";
            header("Location: /../pages/login.php");
            exit();
        }
    }
}
?>
