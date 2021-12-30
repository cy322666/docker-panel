Панель проверка источников

docker-compose up --build -d

панель будет доступна /admin (0.0.0.0:8090->80/tcp | gigant-panel_nginx_1)

настроить крон раз в минуту на команду:

docker exec -it gigant-panel_app_1 php artisan schedule:run
