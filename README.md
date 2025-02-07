Этот проект представляет собой REST API для управления библиотекой, включая регистрацию пользователей, авторизацию, создание книг, их выдачу и возврат.

Установка: 
1 клонируйте репозиторий
2 установите зависимости 
  composer install
3 создайте файл .env
Скопируйте .env.example в .env и настройте подключение к базе данных: cp .env.example .env
Откройте .env и настройте:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=library
DB_USERNAME=root
DB_PASSWORD=ваш-пароль
4 сгенерируйте ключ приложения: 
    php artisan key:generate
5 запустите миграции:
    php artisan migrate

Запуск: 
1 запустите сервер:
    php artisan serve
2 API будет доступен по адресф: http://localhost:8000/api

Тестирование: 
1 Убедитесь, что база данных настроена для тестов:
В .env.testing настройте тестовую базу данных.
2 запустите тесты: 
    php artisan test
