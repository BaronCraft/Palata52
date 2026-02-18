<?php
// Начинаем сессию для хранения информации о входе
session_start();

// Проверяем, пришли ли данные из формы
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: authorize.html');
    exit;
}

// Получаем данные из формы
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Массив с пользователями и их паролями (здесь они в безопасности)
$users = [
    'Матвей' => 'm8012011',
    'Артём' => '',      // пока пусто
    'Оля' => '',        // пока пусто
    'Ксюша' => '',      // пока пусто
    'Ирина' => ''       // пока пусто
];

// Проверяем существование пользователя
if (!array_key_exists($username, $users)) {
    header('Location: authorize.html?error=not_available');
    exit;
}

// Для не-админов (кроме Матвея) вход пока закрыт
if ($username !== 'Матвей') {
    header('Location: authorize.html?error=not_available');
    exit;
}

// Проверяем пароль
if ($users[$username] !== $password) {
    header('Location: authorize.html?error=invalid');
    exit;
}

// Успешный вход!
$_SESSION['user'] = $username;
$_SESSION['logged_in'] = true;

// Перенаправляем в мессенджер
header('Location: messenger.html');
exit;
