# Project to explore new features of Symfony 4

Small and simply project to test new features of Symfony 4.

## Doing

`Copy Past .env.dist and rename it to .env and edit it to add connection information of your database.`

Create database
```sh
php bin/console doctrine:database:create
```
Install dependencies
```sh
composer install
```
Install fake data
```
bin/fixtures
```


### Test as user
?_switch_user=user@gmail.com

### Test as author
?_switch_user=author@gmail.com

