[![Typing SVG](https://readme-typing-svg.herokuapp.com?color=%2336BCF7&lines=Notebook+API+ver.1)](https://git.io/typing-svg)
# Instalation

1. git clone https://github.com/iamfre/notebook-api.git
2. cp .env.example .env
3. composer install
4. php artisan storage:link

# Функционал
* GET /api/v1/notebook/ - получить список записей с пагинацией
* POST /api/v1/notebook/ - добавить новую запись
* GET /api/v1/notebook/<id>/ - получить запись
* POST /api/v1/notebook/<id>/ - обновить запись
* DELETE /api/v1/notebook/<id>/ - удалить запись

# Examples
API documentaion
postman fixtures - https://documenter.getpostman.com/view/16696285/2s8YeptZ7J
