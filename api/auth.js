export default function handler(req, res) {
  // Разрешаем только POST запросы
  if (req.method !== 'POST') {
    return res.status(405).json({ error: 'Метод не разрешен' });
  }

  const { username, password } = req.body;

  // Получаем пароль из переменных окружения (не в коде!)
  const validPassword = process.env[`USER_${username.toUpperCase()}_PASSWORD`];

  // Проверяем пользователя
  if (!validPassword) {
    return res.status(401).json({ error: 'Пользователь не найден' });
  }

  // Сравниваем пароли
  if (password === validPassword) {
    // Успешный вход
    res.status(200).json({ 
      success: true, 
      user: username,
      redirect: '/messenger.html'
    });
  } else {
    res.status(401).json({ error: 'Неверный пароль' });
  }
}
