# Symfony - Hands On project
---

## Forms validation

On framework.yaml add
```sh
    form:
        legacy_error_messages: false // to have more descriptive errors messages

```

On _form.html.twig we already have so if we have any error it should be rendered with the styles we've added most recently:
```sh
    {{ form_start(form, {'attr': {'novalidate': 'novalidate'}}) }}
    <div>{{ form_errors(form) }}</div>

    <div>
        {{ form_label(form.title, 'Please enter the title', {'label_attr': {'class': 'block text-sm text-gray-700 dark:text-gray-300 font-medium'}}) }}
        {{ form_widget(form.title, {'attr': {'class' : 'block w-full shadow-sm border-gray-300 dark:border-transparent dark:text-gray-800 rounded-md border p-2 mt-1 mb-2'}}) }}
        {{ form_errors(form.title) }}
    </div>
```

On MicroPostType we said the form class we would use, which is MicroPostType, so it will take most possible from what is there.
So there will have the data validation.

To avoid client side validation, add ```sh {'attr': {'novalidate': 'novalidate'}}```
```sh
{{ form_start(form, {'attr': {'novalidate': 'novalidate'}}) }}
```

So we can have some validation constraints to avoid the errors:
1. import the validator constraints 
``` use Symfony\Component\Validator\Constraints as Assert;```
2. Then add the validator
```    
    #[Assert\NotBlank()]
    #[Assert\Length(min: 5, max: 500)]
```

Those validators are part of Doctrine, not affecting Schema! And imediately affecting the application. Cool!

As Validator is not Form specific, it can be used independently!

You can see on the _contruct the parameters you can specify in every constraint to be customized to your own.

Please check: ```sh symfony.com/doc/current/validation.html#constraints ``` about all the constraints available: string constraints, comparison constraints, etc. Even user password which will check if the input value is equal to the current user password. As explained there, it is useful when the user changes their password but need to enter the old pwd for security.