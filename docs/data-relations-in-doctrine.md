# Symfony - Hands On project
---

## Database Relations in Doctrine

### One to One Relation
First add security package:
```sh
$ composer require security
```

Then you can use the user option:
```sh
$ symfony console make:user
```

 Next Steps:
   - Review your new App\Entity\User class.
   - Use make:entity to add more fields to your User entity and then run make:migration.
   - Create a way to authenticate! See https://symfony.com/doc/current/security.html


Then we created a new entity: ``` $ symfony console make:entity```
Then we run the migration: ``` $ symfony console make:migration```
```sh
$ symfony console doctrine:migrations:migrate

### One to Many Relation
```sh
$ symfony console make:entity
Class name of the entity to create or update (e.g. GrumpyElephant):
 > UserProfile

 Your entity already exists! So let's add some new fields!

 New property name (press <return> to stop adding fields):
 > user

 Field type (enter ? to see all types) [string]:
 > OneToOne

 What class should this entity be related to?:
 > User

 Is the UserProfile.user property allowed to be null (nullable)? (yes/no) [yes]:
 > no

 Do you want to add a new property to User so that you can access/update UserProfile objects from it - e.g. $user->getUserProfile()? (yes/no) [no]:
 > yes

 A new property will also be added to the User class so that you can access the related UserProfile object from it.

 New field name inside User [userProfile]:
 > 

 updated: src/Entity/UserProfile.php
 updated: src/Entity/User.php

 symfony console make:migration
```

### One to Many Relation
```sh
$ symfony console make:entity
  symfony git:(main) ✗ symfony console make:entity

 Class name of the entity to create or update (e.g. GentlePizza):
 > Comment

 created: src/Entity/Comment.php
 created: src/Repository/CommentRepository.php
 
 Entity generated! Now let's add some fields!
 You can always add more fields later manually or by re-running this command.

 New property name (press <return> to stop adding fields):
 > text

 Field type (enter ? to see all types) [string]:
 > 

 Field length [255]:
 > 500

 Can this field be null in the database (nullable) (yes/no) [no]:
 > 

 updated: src/Entity/Comment.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > 


 Another now:
 $ symfony console make:entity
 ➜  symfony git:(main) ✗ symfony console make:entity

 Class name of the entity to create or update (e.g. VictoriousPuppy):
 > MicroPost

 Your entity already exists! So lets add some new fields!

 New property name (press <return> to stop adding fields):
 > comments

 Field type (enter ? to see all types) [string]:
 > OneToMany

 What class should this entity be related to?:
 > Comment

 A new property will also be added to the Comment class so that you can access and set the related MicroPost object from it.

 New field name inside Comment [microPost]:
 > post

 Is the Comment.post property allowed to be null (nullable)? (yes/no) [yes]:
 > no

 Do you want to activate orphanRemoval on your relationship?
 A Comment is "orphaned" when it is removed from its related MicroPost.
 e.g. $microPost->removeComment($comment)
 
 NOTE: If a Comment may *change* from one MicroPost to another, answer "no".

 Do you want to automatically delete orphaned App\Entity\Comment objects (orphanRemoval)? (yes/no) [no]:
 > yes

 updated: src/Entity/MicroPost.php
 updated: src/Entity/Comment.php

 ➜  symfony git:(main) ✗ symfony console make:migration
 ➜  symfony git:(main) ✗ symfony console doctrine:migrations:migrate
 ```

### Many to Many Relation