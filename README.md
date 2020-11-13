#Symfony book tutorial

## Core information

* Tutorial - https://symfony.com/book
* Online - https://symfony.com/doc/5.0/the-fast-track/en/index.html
* Core git - https://github.com/the-fast-track/

## TO-DO

I will write down all information about installing. Partly different from core tutorial book.

### New project
* install cli - https://symfony.com/download v4.20.0
* or install from composer https://symfony.com/doc/current/setup.html
* start server `symfony server:start --port=8000 -d` - for me it's working on localhost:8000
* https://symfony.com/doc/current/reference/configuration/framework.html#ide
* install php extension `sudo apt install php7.4-pgsql` - well it is not necessary and I had to write out different way to make it working (I have problem with https://symfony.com/doc/current/bundles/EasyAdminBundle/fields.html#formatting-options - `DateTimeField`... who knows where the hell the problem is)
* `symfony local:php:list` show local php servers
* `symfony pecl install xdebug`

#### Reopen project
* `make up`
* mozny problem s neexistujicim symfony se resi pomoci `export PATH="$HOME/.symfony/bin:$PATH"`

### Admin
* after EasyAdmin (3.1 instead of 2.0 from tutorial) install you need to create dashboard (https://symfony.com/doc/master/bundles/EasyAdminBundle/dashboards.html) `php bin/console make:admin:dashboard`
* create CRUD (https://symfony.com/doc/master/bundles/EasyAdminBundle/crud.html) `php bin/console make:admin:crud`
* update Dashboard Controller
* need to instal `php7.4-intl` to show DateTime in Comment list

### database
* login to docker postgresql db `docker exec -it symfony-book_database_1 bash`
* migration up - `symfony doctrine:migrations:migrate`
* show list of migrations -`symfony doctrine:migrations:list`
* migration down (needs to be exact same name as from the list) - `symfony doctrine:migrations:execute 'DoctrineMigrations\Version20200928154415' --down` 

### redis
* update redis and install all you need
* check if redis is working in docker `redis-cli -h 127.0.0.1 -p 32768 ping`
