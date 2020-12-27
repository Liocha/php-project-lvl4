### http://task-manager.liocha.ru

Мой 4й проект  на  [hexlet](https://ru.hexlet.io/?ref=257626) :+1:
    
<p align="center">
<a href="https://github.com/Liocha/php-project-lvl4/actions"><img src="https://github.com/Liocha/php-project-lvl4/workflows/Master%20workflow/badge.svg" /></a>
<a href="https://codeclimate.com/github/Liocha/php-project-lvl4/maintainability"><img src="https://api.codeclimate.com/v1/badges/e502da4681faea3ec3b2/maintainability" /></a>
<a href="https://codeclimate.com/github/Liocha/php-project-lvl4/test_coverage"><img src="https://api.codeclimate.com/v1/badges/e502da4681faea3ec3b2/test_coverage" /></a>
</p>

## Цель

Дипломный проект в обучении. Цель этого проекта, проработка прикладных инструментов веб-разработчика. Фреймворки, базы данных, orm, все это будет здесь. 

## Описание

Task Manager, система управления задачами, подобно [redmine.org](http://redmine.org)

Основные возможности системы:

* Регистрация.
* Управление задачами
* Фильтрация

## Темы:

* Фреймворк Laravel.
* Проектирование. 
* Eloquent ORM, отображение предметной области на хранилище.
* Heroku (PaaS), доставка до рабочего окружения.
* Rollbar, трекинг ошибок в продакшене.
* Makefile, удобное взаимодействие с проектом в процессе разработки.

## Требования

Проверить зависимости PHP можно командой `composer check-platform-reqs`
* PHP ^7.4
* Extensions:
    - dom
    - fileinfo
    - filter
    - json
    - libxml
    - mbstring
    - openssl
    - pcre
    - PDO
    - Phar
    - SimpleXML
    - tokenizer
    - pgsql
    - xml
    - xmlwriter
    - sqlite3
    - tokenizer
    - pcre
    - zip
* Composer
* Node.js (v13.11+) & NPM (6.13+)
* SQLite for local, PostgreSQL or MySQL for production
* [heroku cli](https://devcenter.heroku.com/articles/heroku-cli#download-and-install)

### Установка проекта 

```sh
$ make setup
```

### Запуск проекта в dev режиме

```sh
$ make start
```
### Запуск линтера

```sh
$ make lint
```

### Запуск тестов

```sh
$ make test
```
