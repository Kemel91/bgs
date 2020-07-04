## Тестовое задание: 

###### Создать API-приложение для управления участниками мероприятия.

Участник содержит поля имя/фамилия/email и привязан к мероприятию

Мероприятие содержит поля название/дата проведения/город (для них api не требуется)

 

###### Возможности

1.    Добавлять/получать/изменять/удалять участников через http запрос

2.    Фильтрация данных при запросе (возвращать только участников определенного мероприятия)

 

###### Требования

1.    Использование фреймворка lumen/laravel (можно использовать любые дополнительные пакеты)

2.    Доступ к API закрыт напрямую

3.    Должны быть unit тесты (все покрывать необязательно)

4.    Формат возвращаемых данных - json

5.    Мероприятия уже существуют в базе при запуске приложения

6.    При успешном создании нового участника эмулируется отправка email через очередь (можно писать в лог)

7.    Участник уникален по email

###### Результат

Ссылка на git-репозиторий, содержащий приложение, инструкции для его запуска, инструкции по работе с API

Дополнительное задание (необязательно)

Приложение и его составляющие запускаются внутри docker контейнеров

### Инструкция по использованию
1. Склонировать репозиторий `git clone https://github.com/Kemel91/bgs.git folder`
2. Перейти в папку с проектом cd folder, переименовать `.env.example` в `.env`
3. Запустить сборку контейнера командой `docker-compose up -d --build`
4. После успешной сборки запустить загрузку зависимостей приложения командой `docker-compose exec php composer install`
5. Дождавшись окончания загрузки зависимостей запустить миграции командой `docker-compose exec php php artisan migrate`
6. Если используете PHPStorm и стоит плагин Swagger, перейти в папку docs открыть файл swagger.yaml и запустить и пользоваться
Если нет плагина, запустить Postman(либо другой аналогичный инструмент):
- Для аутентификации послать POST запрос по маршруту: http://localhost/api/auth с данными
    email: hr@bgs-group.eu
    password: 123456
В ответ получите api token, его следует вставить в раздел Autorization->Bearer token
- Для вывода всех участников послать GET запрос по маршруту: http://localhost/api/members
- Для добавления нового участника послать POST запрос по маршруту: http://localhost/api/members с данными
`{
     "firstname": "Имя участника",
     "lastname": "Фамилия",
     "email": "email",
     "events": [
         {
             "id": 3
         },
         {
             "id": 2
         }
     ]
 }`
    Где events.id - идентификаторы мероприятия
- Для редактирования послать эти же данные put методом по маршруту http://localhost/api/members/id - где id - идентификатор участника
- Для просмотра информации участника послать GET запрос по маршруту http://localhost/api/members/id - где id - идентификатор участника
- Для удаления участника послать DELETE запрос по маршруту http://localhost/api/members/id - где id - идентификатор участника
