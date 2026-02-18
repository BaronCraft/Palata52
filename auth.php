<?php
// Начинаем сессию
session_start();

// Разрешаем CORS для Vercel
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Обрабатываем preflight запросы
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Получаем данные из POST запроса
$input = json_decode(file_get_contents('php://input'), true);

// Если нет JSON, пробуем обычный POST
if (!$input) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
} else {
    $username = $input['username'] ?? '';
    $password = $input['password'] ?? '';
}

// Для отладки (можно удалить позже)
error_log("Попытка входа: username=$username");

// Получаем пароль из переменных окружения Vercel
// Имена переменных: USER_МАТВЕЙ_PASSWORD, USER_АРТЁМ_PASSWORD и т.д.
$envVarName = 'USER_' . strtoupper($username) . '_PASSWORD';
$validPassword = getenv($envVarName);

// Проверяем существование пользователя
if ($validPassword === false) {
    http_response_code(401);
    echo json_encode(['error' => 'Пользователь не найден']);
    exit();
}

// Проверяем пароль
if ($password === $validPassword) {
    // Успешный вход
    $_SESSION['user'] = $username;
    $_SESSION['logged_in'] = true;
    
    // Для AJAX запросов
    if ($input) {
        echo json_encode([
            'success' => true,
            'redirect' => '/messenger.html'
        ]);
        exit();
    } else {
        // Для обычной формы
        header('Location: messenger.html');
        exit();
    }
} else {
    // Неверный пароль
    http_response_code(401);
    if ($input) {
        echo json_encode(['error' => 'Неверный пароль']);
    } else {
        header('Location: authorize.html?error=invalid');
    }
    exit();
}
?>
