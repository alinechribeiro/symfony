# Symfony - Hands On project
---

## Authentication & Authorization
On security.yaml we can see we have pre-defined to use hash for passwords and the most updated available.
```sh
security:
    # https://symfony.com/doc/current/security.html#registering-the-user-hashing-passwords
    password_hashers:
        Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface: 'auto'
```

And, when creating the entity User we have chosen email as property. And this definition is shown on the security.yaml file:
```sh
    # https://symfony.com/doc/current/security.html#loading-the-user-the-user-provider
    providers:
        # used to reload user from session & other features (e.g. switch_user)
        app_user_provider:
            entity:
                class: App\Entity\User
                property: email
```

The firewall is only one. 
And on dev mode we make sure that assets or profiler are not blocked. Later on we will configure our main firewall to use the form base of authentication, which must be simple:
```sh
        main:
            lazy: true
            provider: app_user_provider
```

### User
Every user has at least roles pre-defined.

On [/security.yaml](/security.yaml), the access_control will contain <b>specific paths </b> where you specify the user roles are required, so for example:
```sh
    access_control:
        # - { path: ^/admin, roles: ROLE_ADMIN } // the whole are of /admin will be restrict to users with the role ROLE_ADMIN.
        # - { path: ^/profile, roles: ROLE_USER }
```

By the way, every role name must start with <b>ROLE_</b>.
The granted privileges will be done in Controller, templates or even in other classes. And it can be done in PHP 8 attributions or asset.


To create fake user accounts for dev, on AppFixtures.php class responsible for creating new fake data.

Previously, working with Controller we could inject object through methods only for Controllers.

But now we need to create a constructor to pass the dependency.

Create some fake users like that on AppFixtures.php:
```sh
    public function load(ObjectManager $manager): void
    {
        $user1 = new User();
        $user1->setEmail('test@test.com');
        $user1->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user1,
                '12345678'
            )
        );
        $manager->persist($user1);
```

We need to run the following command to load those fake users:
```sh
symfony console doctrine:fixtures:load 
```

We made a cli command (super cool!): check on [/docs/create-console-command.md](/docs/create-console-command.md)

To have a functioning authentication system we need to take 3 steps:
1. configure the [security.yaml](security.yaml).
2. create a Controller that will render the login form.
3. create a template with the login form itself.


1. Configure the [security.yaml](security.yaml).      
```sh  
    main:
        lazy: true
        provider: app_user_provider
        form_login:
            login_path: app_login # it will render the login form. app_login will be the route. login_path is when people need to authenticate in any part of the website, this will be redirected to login_path
            check_path: app_login # we use the same route. that's the route that all credentials will be sent to the check to be verified.
```

2. create a Controller that will render the login form.
```sh
$ symfony console make:controller
```

The only obligatory action is to render the form, nothing else.
But we added the last username so if the user types the wrong password, we already bring the same username for next temptive. This comes from the class use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
We added AuthenticationUtils $utils as parameter in index method and you can check on [/src/Controller/LoginController.php](/src/Controller/LoginController.php) the result. :)

3. create a template with the login form itself.
The template created was [/templates/login/index.html.twig](/templates/login/index.html.twig)

We created form in html, we won't be creating a form type class to be specific. Why? We submit the form to this url 'app_login'. On the LoginController, Symfony will take over the form submission, Symfony will just intercept the request. So we only need to do the html form fields:
_username needs to be this name to be captured by Symfony as username. Same for _password.
If you would like to redirect the url after saving, you can add a hidden input '_target_path' named.
Hint: we could also use path() here or pass the URL to redirect to from the controller eg. user last visited page.

For logout we created:
1. on security.yaml 
```sh
    logout:
        path: app_logout
        target: app_login # where to redirect once the user has logged out.
```

2. We could use any controller, on that case we used LoginController to add the route and method logout():
```sh
    #[Route('/logout', name: 'app_logout')]
    public function logout()
    {}
```
Any logic in the logout action as Symfony will intercept the logout and redirect to the defined path.

3. Added the link logout (same place of the login).