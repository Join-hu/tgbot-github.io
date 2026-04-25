# Telegram Bonus Bot (PHP)

Готовый Telegram бот для заработка бонусов.

## Возможности

- 🎁 Бонус каждые X минут
- 👥 Реферальная система
- 💳 Баланс пользователей
- 🛠 Админ-панель
- 🗄 SQLite база данных

## Установка

### 1. Загрузите проект на хостинг

Требования:
- PHP 7.4+
- SQLite

### 2. Настройте config.php

```php
define('BOT_TOKEN', 'YOUR_TOKEN');
define('ADMIN_ID', 'YOUR_ID');
```

### 3. Создайте базу

Импортируйте install.sql

### 4. Установите webhook

```bash
https://api.telegram.org/botTOKEN/setWebhook?url=https://your-site.com/bot.php
```

## Команды

- /start
- /bonus
- /balance
- /ref

## GitHub

Проект готов для загрузки в GitHub repository.
