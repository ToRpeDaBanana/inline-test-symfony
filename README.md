﻿# inline-test-symfony

## Установка и запуск

### Требования
- PHP 8.1+
- Composer
- Symfony CLI (необязательно, но удобно)
- MySQL

### Шаги по установке

1. **Клонируйте репозиторий:**
   ```bash
   git clone https://github.com/ToRpeDaBanana/inline-test-symfony.git
   ```

2. **Установите зависимости:**
   ```bash
   composer install
   ```

3. **Настройте переменные окружения:**
   - Создайте файл `.env`, если его нет.
   - Укажите параметры подключения к базе данных:
     ```ini
     DATABASE_URL="mysql://username:password@127.0.0.1:3306/db_name"
     ```

4. **Настройка базы данных:**
   ```bash
   php bin/console doctrine:database:create
   php bin/console doctrine:migrations:migrate
   ```

5. **Запустите сервер Symfony:**
   ```bash
   symfony server:start
   ```
   Или через встроенный PHP-сервер:
   ```bash
   php -S 127.0.0.1:8000 -t public
   ```

## Импорт данных
Чтобы импортировать записи и комментарии, выполните команду:
```bash
php bin/console app:import-data
```
Или в строке браузера напишите:
```bash
http://127.0.0.1:8000/import
```

