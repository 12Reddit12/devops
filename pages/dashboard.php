<?php
require_once __DIR__ . '/../controllers/helper.php';
if(!isset($_SESSION['user'])){
    header("Location: /pages/login.php");
    exit();
}
$projects = GetProjects();
?>

<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">

  <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css'>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.2/css/font-awesome.min.css'>

  <link rel="stylesheet" href="/assets/css/main.css">

  
</head>

<body>
     <script src="../assets/js/dashboard.js" defer></script>
<div class="modal">
                <div id="new-task-board-modal" class="modal-content">
                    <form id="new-task-board-form" action="/controllers/createboard.php" method="POST">
                        <h2>Створити проект</h3>
                        <label for="board-name">
                            <p>Назва проекту</p>
                            <input type="text" id="board-name" name="board-name" placeholder="Введіть назву проекту" required>
                        </label>
                        <label for="description">
                            <p>Опис проекту</p>
                            <textarea id="description" name="description" rows="10" required></textarea>
                        </label>
                        <div class="btn-group">
                            <button id="create-btn" class="action-btn" type="submit">Створити</button>
                            <button class="action-btn cancel-btn" type="reset" >Вихід</button>
                        </div>
                    </form>
                </div>
                <div id="more-option-modal" class="modal-content">
                    <form id="more-option-form" action="" method="POST">
                        <h2>Зміна проекту</h3>
                        <input type="hidden" id="task-board-id" name="id">
                        <label for="modify-board-name">
                            <p>Назва проекту</p>
                            <input type="text" id="modify-board-name" name="board-name" placeholder="Введіть назву проекту" required>
                        </label>
                        <label for="modify-description">
                            <p>Опис проекту</p>
                            <textarea id="modify-description" name="description" rows="10" required></textarea>
                        </label>
                        <div class="btn-group">
                            <button id="delete-btn" class="action-btn delete-btn">Видалення</button>
                            <button id="update-btn" class="action-btn" type="submit">Оновлення</button>
                            <button class="action-btn cancel-btn" type="reset">Вихід</button>
                        </div>
                    </form>
                </div>
           </div>
<div class="navbar navbar-fixed-top navbar-default" role="navigation">
    <div class="container-fluid">
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="nav-brand">
                    <img class="avatar" style="height:80px;" src="<?php echo $_SESSION['user']['avatar'] ?>" />
                </li>
                <li class="nav-item flex-fill text-center">
                    <a class="nav-link" href="#"><?php echo $_SESSION['user']['username'] ?></a>
                </li>
                <li class="nav-item flex-fill text-center">
                    <a class="nav-link active" href="/pages/dashboard.php">Головна</a>
                </li>
                <li class="nav-item flex-fill text-center">
                    <a class="nav-link" href="/controllers/logout.php">Вийти з аккаунту</a>
                </li>
            </ul>
        </div>
    </div>
</div>



<div class="container-fluid" style="margin-top: 100px;">

    <div class="row row-offcanvas row-offcanvas-left" >
        <div class="col-xs-6 col-sm-1 sidebar-offcanvas" style="top: 200px;" id="sidebar" role="navigation">
            <div class="sidebar-nav">
                <ul class="nav">

                    <!-- <li class="active"><a href="#">Link</a></li> -->
                    <?php foreach ($projects as $project): ?>
                        <li><a href="/pages/board.php?id=<?php echo htmlspecialchars($project['id']); ?>" class="h3"><?php echo htmlspecialchars($project['name']); ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
           
        </div>
        

        <div class="col-xs-12 col-sm-11">

            <br>
            <div class="jumbotron">
                <a href="#" class="visible-xs" data-toggle="offcanvas"><i class="fa fa-lg fa-reorder"></i></a>
                <h1>Список проектів</h1>
                <button id="new-btn" class="btn">Створити новий</button>
            </div>
            <div class="container">
            <div class="board-container">
                <?php foreach ($projects as $project): ?>
                  <div class="board-card">
                    <div class="card-header">
                        <a class="h3"href="/pages/board.php?id=<?php echo htmlspecialchars($project['id']); ?>"><?php echo htmlspecialchars($project['name']); ?></a>
                        <button class="more-option-btn" data-index=<?php echo htmlspecialchars($project['id']); ?>>
                            <img src="../assets/img/option-dot.svg" alt="">
                        </button>
                    </div>
                    <div class="description-box">
                        <p class="description"><?php echo htmlspecialchars($project['description']); ?></p>
                        <!-- <p class="meta-data">Колонок: <?php echo htmlspecialchars($project['section_num']); ?>, Завдань: <?php echo htmlspecialchars($project['task_num']); ?></p> -->
                    </div>
                   </div>
                   <?php endforeach; ?>
            </div>

        </div>
        


    </div>
  

    <hr>

    <footer>
       
    </footer>

</div>

  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js'></script>

</body>

</html>
