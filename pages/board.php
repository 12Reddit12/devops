<?php
require_once __DIR__ . '/../controllers/helper.php';
if(!isset($_SESSION['user'])){
    header("Location: /pages/login.php");
    exit();
}
$projectId = $_GET['id'];

$projectCur = GetProject($projectId);
$sections = GetSections($projectId);
$projects = GetProjects();
?>

<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  <title>Board</title>
  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">

  <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css'>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.2/css/font-awesome.min.css'>

  <link rel="stylesheet" href="/assets/css/main.css">

  
</head>

<body>
     <script src="../assets/js/board.js" defer></script>
<div class="modal">
                <div id="new-task-board-modal" class="modal-content">
                    <form id="new-task-board-form" action="/controllers/createsection.php" method="POST">
                        <h2>Створення колонки</h3>
                             <input type="hidden" id="board-id" name="id" value="<?php echo $projectId ?>">
                        <label for="board-name">
                            <p>Назва колонки</p>
                            <input type="text" id="board-name" name="board-name" placeholder="Введіть назву колонки" required>
                        </label>
                        <label for="description">
                            <p>Опис</p>
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
                        <div class="form-top-bar">
                            <h2>Оновлення колонки</h3>
                            <button id="new-task-btn" class="new-task-btn">Додати завдання</button>
                        </div>
                        <input type="hidden" id="task-section-id" name="id">
                        <label for="modify-section-name">
                            <p>Назва</p>
                            <input type="text" id="modify-section-name" name="section-name" placeholder="Enter the section name" required>
                        </label>
                        <label for="modify-description">
                            <p>Опис</p>
                            <textarea id="modify-description" name="description" rows="10" required></textarea>
                        </label>
                        <div class="btn-group">
                            <button id="delete-btn" class="action-btn delete-btn">Видалити</button>
                            <button id="update-btn" class="action-btn" type="submit">Оновити</button>
                            <button class="action-btn cancel-btn" type="reset">Вихід</button>
                        </div>
                    </form>
                </div>
                <div id="new-task-modal" class="modal-content">
                    <form id="new-task-form" action="" method="POST">
                        <h2>Створення завдання</h3>
                        <input type="hidden" id="task-section-id-2" name="task-section-id">
                        <label for="task-name">
                            <p>Назва завдання</p>
                            <input type="text" id="task-name" name="task-name" placeholder="Введіть назву завдання" required>
                        </label>
                        <label for="task-description">
                            <p>Опис завдання</p>
                            <textarea id="task-description" name="description" rows="4" required></textarea>
                        </label>
                        <label for="complete-date">
                            <p>Дедлайн</p>
                            <input type="date" name="complete-date" id="complete-date">
                        </label>
                        <div class="btn-group">
                            <button id="create-task-btn" class="action-btn" type="submit">Створити</button>
                            <button class="action-btn cancel-btn" type="reset">Вихід</button>
                        </div>
                    </form>
                </div>
                <div id="task-more-option-modal" class="modal-content">
                    <form id="task-more-option-form" action="" method="POST">
                        <h2>Оновлення завдання</h3>
                        <input type="hidden" id="task-id" name="id">
                        <label for="modify-task-name">
                            <p>Назва завдання</p>
                            <input type="text" id="modify-task-name" name="task-name" placeholder="Enter the task name" required>
                        </label>
                        <label for="modify-description">
                            <p>Опис завдання</p>
                            <textarea id="modify-task-description" name="description" rows="5" required></textarea>
                        </label>
                        <label for="modify-complete-date">
                            <p>Дедлайн</p>
                            <input type="date" id="modify-task-complete-date" name="complete-date" required></textarea>
                        </label>
                        <div class="btn-group">
                            <button id="delete-task-btn" class="action-btn delete-btn">Видалити</button>
                            <button id="update-task-btn" class="action-btn" type="submit">Оновити</button>
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
                <h1><?php echo htmlspecialchars($projectCur['0']['name']); ?></h1>
                <button id="new-btn" class="btn">Створити нову колонку</button>
            </div>
            <div class="container">
            <div class="board-container">
                <?php foreach ($sections as $section): ?>
                  <div class="section-card">
                        <div class="card-header">
                            <h3><?php echo htmlspecialchars($section['name']); ?></h3>
                            <button class="more-option-btn" data-index=<?php echo htmlspecialchars($section['id']); ?>>
                                <img src="../assets/img/option-dot.svg" alt="">
                            </button>
                        </div>
                        <div class="description-box">
                            <p class="description"><?php echo htmlspecialchars($section['description']); ?></p>
                        </div>
                        <div class="task-container">
                            <?php 
                            $tasks = GetTasks($section['id']);
                            foreach ($tasks as $task): ?>
                            <div class="task-card  <?php echo $task['is_completed'] ? 'completed' : ''; ?>" draggable="true">
                                <div class="card-header">
                                    <h3><?php echo htmlspecialchars($task['name']); ?></h3>
                                    <button class="task-more-option-btn" data-index=<?php echo htmlspecialchars($task['id']); ?>>
                                        <img src="../assets/img/option-dot.svg" alt="">
                                    </button>
                                </div>
                                <p class="description"><?php echo htmlspecialchars($task['description']); ?></p>
                                <div class="task-card-bottom">
                                    <div class="complete-group">
                                        <input type="checkbox" name="complete-checkbox" data-index="<?php echo htmlspecialchars($task['id']); ?>" onchange="handleComplete(this)" <?php echo $task['is_completed'] ? 'checked' : ''; ?>>
                                        <span><?php echo $task['is_completed'] ? 'Виконано' : 'Не виконано'; ?></span>
                                    </div>
                                    <span><?php echo htmlspecialchars($task['complete_date']); ?></span>
                                </div>
                            </div>
                             <?php endforeach; ?>
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
