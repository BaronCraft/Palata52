<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Здесь проверка в базе данных или в конфиге
    // Для примера:
    if ($username === 'Матвей' && $password === 'm8012011') {
        $_SESSION['user'] = $username;
        header('Location: messenger.html');
        exit;
    } else {
        header('Location: authorize.html?error=1');
        exit;
    }
}
?>
