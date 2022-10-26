# Symfony - Hands On project
---

## Installation
### Use Git
```sh
$ git clone git@github.com:alinechribeiro/symfony6-hands-on.git
```
### Mac
1. Install Homebrew (https://brew.sh/). Restart Terminal.
2. Run brew update
3. Run brew tap shivammathur/php
4. Run brew install shivammathur/php/php@8.1
5. Run php -v to see if PHP is installed and works
6. Install Composer by running php composer-setup.php --install-dir=bin --filename=composer
7. In the same directory run mv composer.phar /usr/local/bin/composer if that fails, run sudo mv composer.phar /usr/local/bin/composer
8. Restart Terminal, run composer -v, you should see Composer welcome message
9. Install Symfony CLI
* 		brew install symfony-cli/tap/symfony-cli
10. Restart Terminal, you run symfony - you should see the Symfony CLI message
11. Download and install Docker Desktop for Mac - https://docs.docker.com/desktop/install/mac-install/

### Dev Environment set-up
Run once:
```sh
$ cd symfony
$ cp .env.example .env
$ composer i
$ docker-compose -f .infrastructure/docker/docker-compose.yml up -d --build
$ docker exec symfony php /app/artisan migrate
```
```sh
$composer require annotations

$ symfony console debug:router
 ---------------- -------- -------- ------ -------------------------- 
  Name             Method   Scheme   Host   Path                      
 ---------------- -------- -------- ------ -------------------------- 
  _preview_error   ANY      ANY      ANY    /_error/{code}.{_format}  
  app_index        ANY      ANY      ANY    /                         
  app_show_one     ANY      ANY      ANY    /messages/{id}            
 ---------------- -------- -------- ------ -------------------------- 
```
##### We are using twig templates:
```sh
$ composer require twig
```
##### We are using The Symfony MakerBundle
```sh
$ composer require --dev symfony/maker-bundle
```

##### Get the ORM package 
```sh
$ composer require symfony/orm-pack
```
##### Create docker-compose.yml file
```sh
version: "3.8"
services:
  mysql:
    image: mariadb:10.8.3
    # Uncomment below when on Mac M1
    platform: linux/arm64/v8
    command: --default-authentication-plugin=mysql_native_password
    restart: always
    environment:
      MYSQL_ROOT_PASSWORD: root
    ports:
      - 3987:3306
  adminer:
    image: adminer
    restart: always
    ports:
      - 8055:8080
  mailer:
    image: schickling/mailcatcher
    ports:
      - 1080:1080
      - 1025:1025
```

## Another very important tool is the Profiler
```sh
$ composer require --dev symfony/profiler-pack
```

##### Databased configuration
Go to symfony.com/doc/current/doctrine.html#configuring-the-database
# .env (or override DATABASE_URL in .env.local to avoid committing your changes)

# customize this line!
# to use mariadb:
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=mariadb-10.5.8"
On doctrine.yaml, doctrine > dbal >  server_version: '10.8.3'
Then:
```sh
$ symfony console list doctrine
$ symfony console doctrine:database:create
$ symfony server:start
$ symfony console make:entity
$ symfony console make:migration
$ symfony console doctrine:migrations:status // gives you the status of your migrations
$ symfony console doctrine:migrations:migrate
$ symfony console doctrine:migrations:migrate prev //backward the schema
```

## Add some fake data with DoctrineFixturesBundle
```sh
$ composer require --dev orm-fixtures  //install the library
```
It creates AppFixtures.php with load method to store some fake data. Dependency injection happens here.

That's why we created like that:
```
class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $microPost1 = new MicroPost();
        $microPost1->setTitle('Welcome to Poland!');
        $microPost1->setText('Welcome to Poland!');
        $microPost1->setCreated(new DateTime());
        $manager->persist($microPost1);

        $microPost2 = new MicroPost();
        $microPost2->setTitle('Welcome to US!');
        $microPost2->setText('Welcome to US!');
        $microPost2->setCreated(new DateTime());
        $manager->persist($microPost2);

        $microPost3 = new MicroPost();
        $microPost3->setTitle('Welcome to Brazil!');
        $microPost3->setText('Welcome to Brazil!');
        $microPost3->setCreated(new DateTime());
        $manager->persist($microPost3);

        $manager->flush();
    }
}

```

And the command to run the fixtures is
```sh
$ symfony console doctrine:fixtures:load
```


 Next: Review the new migration "migrations/Version20221015184914.php"
 Then: Run the migration with php bin/console doctrine:migrations:migrate
 See https://symfony.com/doc/current/bundles/DoctrineMigrationsBundle/index.html

# migrations:
```sh
$ php bin/console doctrine:migrations:migrate
```

### Framework called extra bundle
```sh
$ composer require sensio/framework-extra-bundle
```

# DoctrineFixturesBundle
symfony.com/bundles/DoctrineFixturesBundle/current/index.html#installation

#SensioFramework
symfony.com/bundles/SensioFrameworkExtraBundle/current/annotations/converters.html
```sh
composer require sensio/framework-extra-bundle
```

# Creating form
symfony.com/doc/current/forms.html#installation
```sh
$ composer require symfony/form
```
<!-- ##### Enter service container bash:
```sh
$ docker exec -it symfony6-hands-on bash
``` -->
<!-- 
##### Enter db container bash:
```sh
$ docker exec -it symfony6-hands-on bash
```
##### Symfony The Profiler: great tool
```sh
composer require --dev symfony/profiler-pack
```

##### TIP: To create migration and migrate
To create migration
```sh
$ docker exec symfony6-hands-on php /app/artisan make:migration "<migration message>"
```

To Migrate from inside the container 
```sh
$ docker exec -it symfony6-hands-on bash
$ php artisan migrate
```
To Migrate from local machine
```sh
$ docker exec symfony6-hands-on php /app/artisan migrate
```

##### TIP: To set up Xdebug
Xdebug has already been enabled on container and remote host has been set up for PHPSTORM on mac
If you are not using phpstorm or mac do the following
```sh
$ docker exec -it symfony6-hands-on bash
$ vi /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
```
Change xdebug.client_host and xdebug.idekey on above ini file to suit your need

###### Note: Installed version of xdebug is 3 and ONLY PHPSTORM 2020.3 and above supports xdebug 3

How to set up xdebug with phpstorm: https://www.jetbrains.com/help/phpstorm/configuring-xdebug.html#integrationWithProduct -->

### We added Bootstrap to base.html.twig (https://getbootstrap.com/)

#### From Symfony documentation (https://symfony.com/doc/current/forms.html#rendering-forms) we added on twig.yaml the  following
# the file: config/packages/twig.yaml
```sh 
twig:
    form_themes: ['bootstrap_5_layout.html.twig']
```

#### but we're going to use Tailwind so utility classes will be the choice. Commented out the bootstrap library on twig.yaml and on base.html.twig. Just in case we wanna use it in the future we can see this possibility. :)

### Creating form classes: symfony.com/doc/current/forms.html#creating-form-classes
```sh
symfony console make:form
```

#### Creating your Own Form Theme: symfony.com/doc/current/form/form_themes.html#customizing-the-form-validation-errors

On twig.yaml you defined your form theme like that:
```sh
twig:
    default_path: '%kernel.project_dir%/templates'
    form_themes:
        - 'form/fields.html.twig'
```

### First thing for your form theme: Install the validator component
```sh
$ composer require symfony/validator
```

Check the possibilities of validation on https://symfony.com/doc/current/validation.html#constraints, some of the validations are very powerful and can even interact with the db as well.


### To have more descriptive messsage errors, add inside config/packages/framework.yaml:
```
form:
  legacy_error_messages: false
```

Database Relations in Doctrine see on /docs/data-relations-in-doctrine.md