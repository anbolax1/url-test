При разработке использовать фреймворк Yii2

Готовый код разместить на Github.

Использовать встроенные классы Yii2 (контроллеры, модели, экшены)


Тестовое задание:
Разработать простой REST-сервис.



1) Создать таблицу и модель данных с использованием драйвера MySQL со стандартным файлом миграции Yii2 со следующей структурой.
   Тип и длину полей подберите, исходя из задания и прокомментируйте, что бы вы еще в нее добавили?

Структура таблицы
hash_string

created_at

updated_at
url

status_code

query_count



2) Создать эндпоинт сервиса /CheckStatus, который принимает POST-запрос со списком URL в формате application/json.

Для каждого URL из входящего запроса:

- проверить существование такого URL в таблице (по хэшу):

--------------
При наличии URL в таблице:


Если с момента последнего обновления прошло более 10 минут:
*  обновить status_code
*  увеличить счетчик просмотров query_count
*  обновить updated_at

Если прошло меньше 10 минут:
* получить status_code из таблицы
* увеличить счетчик query_count


--------------
При отсутствии URL в таблице:

Создать новую запись
* hash_string - вычислить как MD5-сумму от URL
* created_at, updated_at - текущее время
* status_code - HTTP-код ответа страницы
* url - обрабатываемый URL
* query_count = 1

Таймаут ответа для всех проверок - 5 секунд, в случае таймаута - в поле status_code записать значение 0.

Сформировать ответ в JSON, в котором каджому URL сопоставлен полученный HTTP-код.
Ответ должен представлять собой массив codes, элементами которого является объекты с полями url (запрашиваемый адрес) и code - HTTP-код ответа


3. Разработать консольную команду
   Вызов команды yii check-status/statistics должен выводить в STDOUT информацию по всем запросам за последние 24 часа (по полю updated_at), у которых статус ответа не равен 200.
   В выводе должны присутствовать поля url и status_code. Формат произвольный.

4. Дополнительно (не обязательно)
   Выполнение дополнительных требований не обязательно, но желательно. Если какое-то из них не получается выполнить, просьба объяснить причину. Например: большие трудозатраты, никогда не сталкивался с такой задачей и т.д.
   Если требования не выполняются по причине больших трудозатрат, просьба как минимум обозначить ход решения задачи и оценку времени на выполнение.

4.1 Использовать для проверки кеша (10-минутного таймаута) Redis.
4.2 Разработать консольную команду, которая будет запускаться в кроне по уже собранным URL, которая в случае 5 неудачных попыток (таймаутов или других кодов ответа НЕ 200*) - больше никогда не будет проверять URL из таблицы.

