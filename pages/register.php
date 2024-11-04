<?php
require_once __DIR__ . '/../controllers/helper.php';
if(isset($_SESSION['user'])){
    header("Location: /pages/dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="/assets/css/login.css"/>
</head>
<body>


<div class="wrapper">
    <form class="form-signin" action="/controllers/register.php" method="POST" enctype="multipart/form-data">       
      <h2 class="form-signin-heading">Створення аккаунту</h2>
      <small><?php GetErrorMsg('error') ?></small>
      <input type="text" class="form-control <?php GetErrorAttr('name') ?>" name="username" placeholder="Логін"  required="" autofocus="" />
      <?php if(HasError('name')): ?>
         <small><?php GetErrorMsg('name') ?></small>
         <?php endif; ?>
      <input type="password" class="form-control" name="password" placeholder="Пароль" required=""/>

            <label>Зображення профілю</label>
            <input type="file" for="avatar" class="form-control-file" id="avatar" name="avatar">
            <?php if(HasError('avatar')): ?>
         <small><?php GetErrorMsg('avatar') ?></small>
         <?php endif; ?>
      <button class="form-control" onclick="location.href='login.php' ">Вже є аккаунт? Авторизуйся тут.</button>
      <button class="btn btn-lg btn-primary btn-block form-control" type="submit">Зареєструватись</button>   
    </form>
  </div>
  <?php ClearValidation(); ?>

</body>

</html>

  