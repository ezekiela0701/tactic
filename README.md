# tactic
**1- cloner le projet**
git clone https://github.com/ezekiela0701/tactic.git

**2- installer composer**
composer install

**3- create database**
php bin/console doctrine:database:create

**4- creer les tables**
php bin/console d:s:u --force

**5- lancer le projet**
php bin/console server:run
