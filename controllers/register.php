<?php
session_start();
if(isset($_SESSION['user'])){
    header("Location: /../pages/dashboard.php");
    exit();
}

require_once __DIR__ . '/../config/db.php';

$_SESSION['validation'] = [];
$uploadPath = '../assets/img/profiles/';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $avatar = $_FILES['avatar'] ?? null;
    
    if (empty($username) || empty($password)) {
      $_SESSION['validation']['error'] = "Всі поля повинні бути заповнені!";
        header("Location: /../pages/register.php");
        exit();
    } else {
        
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->rowCount() > 0) {
            $_SESSION['validation']['name'] = "Користувач з таким логіном вже існує!";
            header("Location: /../pages/register.php");
            exit();
        } else {
           
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            if (!empty($avatar) && $avatar['size'] != 0){
            	
            	$types = ['image/jpeg','image/jpg', 'image/png'];
            	if (!in_array($avatar['type'],$types)){
            		$_SESSION['validation']['avatar'] = "Зображення має не вірний формат (jpeg,jpg,png)!";
		            header("Location: /../pages/register.php");
		            exit();
            	}
            	if (($avatar['size'] / 1000000) >= 2)
            	{
            		$_SESSION['validation']['avatar'] = "Зображення дуже велике (макс. до 2мб)!";
		            header("Location: /../pages/register.php");
		            exit();
            	}
            	if (!is_dir($uploadPath)){

            		mkdir($uploadPath);
            	}

            	$ext = pathinfo($avatar['name'],PATHINFO_EXTENSION);

            	$fileName = 'avatar_' . time() . ".$ext";

            	if (!move_uploaded_file($avatar['tmp_name'], "$uploadPath/$fileName")){
            		$_SESSION['validation']['avatar'] = "Помилка завантаження зображення на сервер. Спробуйте ще раз";
		            header("Location: /../pages/register.php");
		            exit();
            	}

            $stmt = $pdo->prepare("INSERT INTO users (username, password,avatar) VALUES (?, ?, ?)");
            if ($stmt->execute([$username, $hashed_password,"$uploadPath$fileName"])) {
                header("Location: /../pages/login.php");
                exit();
            } else {
                $_SESSION['validation']['error'] = "Помилка реєстрації, спробуйте ще раз!";
                header("Location: /../pages/register.php");
                exit();
            }
            }

            $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            if ($stmt->execute([$username, $hashed_password])) {
                header("Location: /../pages/login.php");
                exit();
            } else {
                $_SESSION['validation']['error'] = "Помилка реєстрації, спробуйте ще раз!";
                header("Location: /../pages/register.php");
                exit();
            }
        }
    }
}

?>
