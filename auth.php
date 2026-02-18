<?php
session_start();

// Данные пользователей (можно добавить других позже)
$users = [
    'Матвей' => 'm8012011'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Проверяем существует ли пользователь
    if (!isset($users[$username])) {
        header('Location: authorize.html?error=not_found');
        exit;
    }
    
    // Проверяем пароль
    if ($users[$username] === $password) {
        $_SESSION['user'] = $username;
        $_SESSION['logged_in'] = true;
        header('Location: messenger.html');
        exit;
    } else {
        header('Location: authorize.html?error=wrong_password');
        exit;
    }
} else {
    header('Location: authorize.html');
    exit;
}
?>
