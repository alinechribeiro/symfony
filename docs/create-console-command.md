# Symfony - Hands On project
---

## Custom Console Command Creating Users
Create your own cli command! Use a generator from Symfony:
```sh
➜  symfony git:(main) ✗ symfony console make:command

 Choose a command name (e.g. app:brave-puppy):
 > app:create-user

 created: src/Command/CreateUserCommand.php

           
  Success! 
           

 Next: open your new command class and customize it!
 Find the documentation at https://symfony.com/doc/current/console.html
```
You can check your new console command on [/src/Command/CreateUserCommand](/src/Command/CreateUserCommand)

You can even check on typing: ```sh $ symfony console app ```
It will show it is already on the list. :)

Let's look the command class look like:
The execute command will run your logics with inside parameters input and output.

We created on [/src/Command/CreateUserCommand.php](/src/Command/CreateUserCommand.php) the example of cli command.

In this link https://symfony.com/doc/current/console.html you can check interactions with the user for sensible data in the cli command, i.e. instead of typing the pwd that will be exposed to the history, we could use 'Question Helper':
https://symfony.com/doc/current/components/console/helpers/questionhelper.html
