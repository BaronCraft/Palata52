export default function handler(req, res) {
  // Разрешаем CORS
  res.setHeader('Access-Control-Allow-Origin', '*');
  res.setHeader('Access-Control-Allow-Methods', 'POST, OPTIONS');
  res.setHeader('Access-Control-Allow-Headers', 'Content-Type');

  if (req.method === 'OPTIONS') {
    return res.status(200).end();
  }

  if (req.method !== 'POST') {
    return res.status(405).json({ error: 'Метод не разрешен' });
  }

  try {
    const { username, password } = req.body;

    // Получаем пароль из переменных окружения
    // Преобразуем имя в формат переменной: "Матвей" -> "MATVEY"
    const envVarName = `USER_${username.toUpperCase().replace('Ё', 'Е')}_PASSWORD`;
    const validPassword = process.env[envVarName];

    console.log('Проверка пользователя:', username);
    console.log('Ищем переменную:', envVarName);
    console.log('Найден пароль:', validPassword ? '✅' : '❌');

    if (!validPassword) {
      return res.status(401).json({ error: 'Пользователь не найден' });
    }

    if (password === validPassword) {
      return res.status(200).json({ 
        success: true, 
        redirect: '/messenger.html'
      });
    } else {
      return res.status(401).json({ error: 'Неверный пароль' });
    }
    
  } catch (error) {
    console.error('Ошибка:', error);
    return res.status(500).json({ error: 'Ошибка сервера' });
  }
}
