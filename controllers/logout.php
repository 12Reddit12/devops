<?php
session_start();
if(isset($_SESSION['user'])){
    unset($_SESSION['user']);
    header("Location: /../pages/login.php");
    exit();
}
    header("Location: /../pages/login.php");
    exit();
?>
