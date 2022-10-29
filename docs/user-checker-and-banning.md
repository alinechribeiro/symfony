# Symfony - Hands On project
---

## User Checker 
Check about it on https://symfony.com/doc/current/security/user_checkers.html

We start modifying the User entity running:
```sh
$ symfony console make:entity

 Class name of the entity to create or update (e.g. FierceChef):
 > User

 Your entity already exists! So let's add some new fields!

 New property name (press <return> to stop adding fields):
 > bannedUntil

 Field type (enter ? to see all types) [string]:
 > datetime

 Can this field be null in the database (nullable) (yes/no) [no]:
 > yes

 updated: src/Entity/User.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > 


           
  Success! 
           

 Next: When you're ready, create a migration with php bin/console make:migration
 
2022-10-29T00:05:53+00:00 [info] User Deprecated: The "Symfony\Bridge\Doctrine\Logger\DbalLogger" class implements "Doctrine\DBAL\Logging\SQLLogger" that is deprecated Use {@see \Doctrine\DBAL\Logging\Middleware} or implement {@see \Doctrine\DBAL\Driver\Middleware} instead.
```


Then let's run:
```sh
$ symfony console make:migration
$ symfony console doctrine:migrations:migrate
```