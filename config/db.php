<?php
$host = getenv('MYSQL_HOST') ?: 'myappdb-service';
$db = getenv('MYSQL_DATABASE') ?: 'todolist';
$user = getenv('MYSQL_USER') ?: 'root';
$pass = getenv('MYSQL_PASSWORD') ?: 'todolistpswd';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
  
    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MySQL Error</title>
        <style>
            body {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                font-family: Arial, sans-serif;
                background-color: #f0f0f0;
                color: #333;
                text-align: center;
            }
            h1 {
                font-size: 2em;
            }
            p {
                font-size: 1.2em;
            }
        </style>
    </head>
    <body>
        <div>
            <h1>MySQL not working</h1>
            <p>Please wait, we are working to fix the issue.</p>
            <pre>' . htmlspecialchars($e->getMessage()) . '</pre>
        </div>
    </body>
    </html>';
    exit;
}
?>
