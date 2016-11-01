## LARAVEL ##

###EVENTS ##########
## Requirements ######################
1. laravel 5.3
2. angular 1

## Installation steps ################
1. create project directory and paste this code folder in it.

2. cd project folder
( Please configure virtual host to run this folder and point it project folder/public/)

3. Run : chmod 0777 -R storage
         chmod 0777 -R bootstrap/cache
         chmod 0777 -R public

4. Run /Database/db.sql from phpmyadmin or workbench
    - This will create database, require tables and test data

5. update .env file for database connection, update below variables
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=
        DB_USERNAME=
        DB_PASSWORD=

6. Run : composer update

7. To tun testcase : run phpunit
