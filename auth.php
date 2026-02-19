<?php
session_start();

// Массив с пользователями и паролями
$users = [
    'Матвей' => 'm8012011',  // Ваш пароль без изменений
    'Артём' => 'gH7#kL9$qR2',      // сгенерировано
    'Ксюша' => 'mN4&bJ8#pT5',      // сгенерировано
    'Оля' => 'xR9$vM2#kL7',        // сгенерировано
    'Ирина' => 'wP6#nH3&fD8'       // сгенерировано
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Проверяем существование пользователя
    if (!array_key_exists($username, $users)) {
        header('Location: authorize.html?error=user_not_found');
        exit;
    }
    
    // Для всех кроме Матвея вход пока закрыт (можно убрать это условие позже)
    if ($username !== 'Матвей') {
        header('Location: authorize.html?error=not_available');
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
