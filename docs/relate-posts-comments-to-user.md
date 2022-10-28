# Symfony - Hands On project
---

## Relate Posts & Comments to User
```s
$ symfony console make:entity
```

to MicroPost to add this relationship between then.
```sh
$ symfony console make:entity

 Class name of the entity to create or update (e.g. OrangePopsicle):
 > MicroPost

 Your entity already exists! So lets add some new fields!

 New property name (press <return> to stop adding fields):
 > author

 Field type (enter ? to see all types) [string]:
 > ManyToOne

 What class should this entity be related to?:
 > User

 Is the MicroPost.author property allowed to be null (nullable)? (yes/no) [yes]:
 > no

 Do you want to add a new property to User so that you can access/update MicroPost objects from it - e.g. $user->getMicroPosts()? (yes/no) [yes]:
 > 

 A new property will also be added to the User class so that you can access the related MicroPost objects from it.

 New field name inside User [microPosts]:
 > posts

 Do you want to activate orphanRemoval on your relationship?
 A MicroPost is "orphaned" when it is removed from its related User.
 e.g. $user->removeMicroPost($microPost)
 
 NOTE: If a MicroPost may *change* from one User to another, answer "no".

 Do you want to automatically delete orphaned App\Entity\MicroPost objects (orphanRemoval)? (yes/no) [no]:
 > no

 updated: src/Entity/MicroPost.php
 updated: src/Entity/User.php
 ```

 We need to do the same with Comment
 ```sh
 $ symfony console make:entity

 Class name of the entity to create or update (e.g. OrangeKangaroo):
 > Comment

 Your entity already exists! So let's add some new fields!

 New property name (press <return> to stop adding fields):
 > author

 Field type (enter ? to see all types) [string]:
 > ManyToOne

 What class should this entity be related to?:
 > User

 Is the Comment.author property allowed to be null (nullable)? (yes/no) [yes]:
 > no

 Do you want to add a new property to User so that you can access/update Comment objects from it - e.g. $user->getComments()? (yes/no) [yes]:
 > 

 A new property will also be added to the User class so that you can access the related Comment objects from it.

 New field name inside User [comments]:
 > 

 Do you want to activate orphanRemoval on your relationship?
 A Comment is "orphaned" when it is removed from its related User.
 e.g. $user->removeComment($comment)
 
 NOTE: If a Comment may *change* from one User to another, answer "no".

 Do you want to automatically delete orphaned App\Entity\Comment objects (orphanRemoval)? (yes/no) [no]:
 > 

 updated: src/Entity/Comment.php
 updated: src/Entity/User.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > 


           
  Success! 
           

 Next: When you're ready, create a migration with php bin/console make:migration
 ```


 Now we need to run
 ```sh

 $ symfony console make:migration

 ```

 And run the migration
 ```sh
 $ symfony console doctrine:migrations:migrate
 ```
 Only in dev, we dropped the schema because of the new relations on tables User, comments and posts.

 ```sh
 $ symfony console doctrine:schema:drop --force #never in production!!
 $ symfony console doctrine:schema:create
```

We updated the /src/DataFixtures/AppFixtures.php to reflect the changes adding setAuthor to the 3 insertions we had there:
```sh
        $microPost1->setAuthor($user1);
```

Then we loaded the table again with fake data running:
```
 $ symfony console doctrine:fixtures:load
 ```