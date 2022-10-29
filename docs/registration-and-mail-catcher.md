# Symfony - Hands On project
---

## Setting Up Registration Controller and Mail Catcher
```sh
$ symfony console make:registration-form
➜  symfony git:(main) symfony console make:registration-form

 Creating a registration form for App\Entity\User

 Do you want to add a @UniqueEntity validation annotation on your User class to make sure duplicate accounts aren't created? (yes/no) [yes]:
 > yes

 Do you want to send an email to verify the user's email address after registration? (yes/no) [yes]:
 > yes

                                                                                                                        
 [WARNING] We're missing some important components. Don't forget to install these after you're finished.                
                                                                                                                        
           composer require symfonycasts/verify-email-bundle symfony/mailer                                             
                                                                                                                        

 By default, users are required to be authenticated when they click the verification link that is emailed to them.
 This prevents the user from registering on their laptop, then clicking the link on their phone, without
 having to log in. To allow multi device email verification, we can embed a user id in the verification link.

 Would you like to include the user id in the verification link to allow anonymous email verification? (yes/no) [no]:
 > no

 What email address will be used to send registration confirmations? (e.g. mailer@your-domain.com):
 > accounts@micropost.com

 What "name" should be associated with that email address? (e.g. Acme Mail Bot):
 > MicroPost Symfony 6

 Do you want to automatically authenticate the user after registration? (yes/no) [yes]:
 > yes

 ! [NOTE] No Guard authenticators found - so your user won't be automatically authenticated after registering.          

 What route should the user be redirected to after registration?:
  [0 ] app_micro_post_add
  [1 ] _preview_error
  [2 ] _wdt
  [3 ] _profiler_home
  [4 ] _profiler_search
  [5 ] _profiler_search_bar
  [6 ] _profiler_phpinfo
  [7 ] _profiler_xdebug
  [8 ] _profiler_search_results
  [9 ] _profiler_open_file
  [10] _profiler
  [11] _profiler_router
  [12] _profiler_exception
  [13] _profiler_exception_css
  [14] app_index
  [15] app_show_one
  [16] app_login
  [17] app_logout
  [18] app_micro_post
  [19] app_micro_post_show
  [20] app_micro_post_edit
  [21] app_micro_post_comment
 > 18

 updated: src/Entity/User.php
 updated: src/Entity/User.php
 created: src/Security/EmailVerifier.php
 created: templates/registration/confirmation_email.html.twig
 created: src/Form/RegistrationFormType.php
 created: src/Controller/RegistrationController.php
 created: templates/registration/register.html.twig

           
  Success! 
           

 Next:
 1) Install some missing packages:
      composer require symfonycasts/verify-email-bundle symfony/mailer
 2) In RegistrationController::verifyUserEmail():
    * Customize the last redirectToRoute() after a successful email verification.
    * Make sure you're rendering success flash messages or change the $this->addFlash() line.
 3) Review and customize the form, controller, and templates as needed.
 4) Run "php bin/console make:migration" to generate a migration for the newly added User::isVerified property.

 Then open your browser, go to "/register" and enjoy your new form!
 ```

 Then we run the first reminder of missing packages:
 ```sh
 ➜  symfony git:(main) ✗ composer require symfonycasts/verify-email-bundle symfony/mailer
Info from https://repo.packagist.org: #StandWithUkraine
Using version ^1.12 for symfonycasts/verify-email-bundle
./composer.json has been updated
Running composer update symfonycasts/verify-email-bundle symfony/mailer
Loading composer repositories with package information
Restricting packages listed in "symfony/symfony" to "6.1.*"
Updating dependencies
Lock file operations: 5 installs, 0 updates, 0 removals
  - Locking egulias/email-validator (3.2.1)
  - Locking symfony/mailer (v6.1.7)
  - Locking symfony/mime (v6.1.7)
  - Locking symfony/polyfill-intl-idn (v1.26.0)
  - Locking symfonycasts/verify-email-bundle (v1.12.0)
Writing lock file
Installing dependencies from lock file (including require-dev)
Package operations: 5 installs, 0 updates, 0 removals
  - Downloading symfony/polyfill-intl-idn (v1.26.0)
  - Downloading symfony/mime (v6.1.7)
  - Downloading egulias/email-validator (3.2.1)
  - Downloading symfony/mailer (v6.1.7)
  - Downloading symfonycasts/verify-email-bundle (v1.12.0)
  - Installing symfony/polyfill-intl-idn (v1.26.0): Extracting archive
  - Installing symfony/mime (v6.1.7): Extracting archive
  - Installing egulias/email-validator (3.2.1): Extracting archive
  - Installing symfony/mailer (v6.1.7): Extracting archive
  - Installing symfonycasts/verify-email-bundle (v1.12.0): Extracting archive
Generating optimized autoload files
67 packages you are using are looking for funding.
Use the `composer fund` command to find out more!

Symfony operations: 2 recipes (f01ef4c33ef83b9e565a2bb0085e55a7)
  - Configuring symfony/mailer (>=4.3): From github.com/symfony/recipes:main
  -  WARNING  symfony/mailer (>=4.3): From github.com/symfony/recipes:main
    The recipe for this package contains some Docker configuration.

    This may create/update docker-compose.yml or update Dockerfile (if it exists).

    Do you want to include Docker configuration from recipes?
    [y] Yes
    [n] No
    [p] Yes permanently, never ask again for this project
    [x] No permanently, never ask again for this project
    (defaults to y): y
  - Configuring symfonycasts/verify-email-bundle (>=v1.12.0): From auto-generated recipe
Executing script cache:clear [OK]
Executing script assets:install public [OK]
              
 What's next? 
              

Some files have been created and/or updated to configure your new packages.
Please review, edit and commit them: these files are yours.

 symfony/mailer  instructions:

  * You're ready to send emails.

  * If you want to send emails via a supported email provider, install
    the corresponding bridge.
    For instance, composer require mailgun-mailer for Mailgun.

  * If you want to send emails asynchronously:

    1. Install the messenger component by running composer require messenger;
    2. Add 'Symfony\Component\Mailer\Messenger\SendEmailMessage': amqp to the
       config/packages/messenger.yaml file under framework.messenger.routing
       and replace amqp with your transport name of choice.

  * Read the documentation at https://symfony.com/doc/master/mailer.html

No security vulnerability advisories found
```

Then we run the symfony migration:
```sh
symfony console make:migration
```

Once it's complete, let's run the migration:
```sh
$ symfony console doctrine:migrations:migrate
```

After restarted docker compose, we have the link to Mail Catcher: http://0.0.0.0:1080/