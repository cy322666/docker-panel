#Панель проверка источников

+ заполнить доступы к виджету amoCRM в application/.env.example

**команда** : `docker-compose up --build -d`

панель будет доступна **/admin** (0.0.0.0:8090->80/tcp | gigant-panel_nginx_1)

+ настроить крон раз в минуту:

**команда** : `docker exec -it gigant-panel_app_1 php artisan schedule:run`

+ настроить хук на создание сделки в amoCRM на адрес: 

**/api/cron/hook**

