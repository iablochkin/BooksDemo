Быстрый способ установки - запустите bash файл
bash init.sh

Другой способ установки

Забилдите и поднимите докер
docker compose build
docker compose up -d

Установите зависимости
docker compose exec php composer install

создайте БД
docker compose exec php php bin/console doctrine:database:create

Замигрируйте её
docker compose exec php php bin/console doctrine:migrations:migrate

Наполните данными 
docker compose exec php php bin/console doctrine:fixtures:load

Другое
Команда удаления авторов без книг
bin/console app:delete-useless-authors


Пути
Добавление автора (метод POST)
Путь: /author
Параметры:
- (string) first_name
- (string) second_name

Редактирование издателя (метод POST)
Путь: /publisher/edit/{!id}
Параметры:
- (string) name
- (string) address

Добавление книги (метод POST)
Путь: /book
Параметры:
- (string) name
- (integer) year
- (id) publisher
- (id) author

Выборка книг с отношениями (метод GET)
Путь: /book