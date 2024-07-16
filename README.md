# user crud

```
composer require symfony/orm-pack
composer require --dev symfony/maker-bundle
composer require annotations ??1
```

```
php bin/console make:user
php bin/console make:migration
php bin/console doctrine:migrations:migrate
php bin/console make:crud User  ??1
```

```
php bin/console make:registration-form
php bin/console make:security:form-login
```
### form
```html
{{ form_start(form) }}
        {{ form_row(form.username) }}
        {{ form_row(form.email) }}
        {{ form_row(form.password) }}
        {{ form_label(form.roles) }}
        {{ form_widget(form.roles) }}
<button type="submit">Save</button>
{{ form_end(form) }}
```

```php
->add('roles', ChoiceType::class, [
        'choices' => [
            'User' => 'ROLE_USER',
            'Admin' => 'ROLE_ADMIN',
        ],
        'multiple' => true,
        'expanded' => true, // Set to true to render as checkboxes
    ]);
```

```yaml
#  config/packages/security.yaml
  access_control:
    - { path: ^/$, roles: PUBLIC_ACCESS }
    - { path: ^/main$, roles: PUBLIC_ACCESS }
    - { path: ^/hello$, roles: PUBLIC_ACCESS }
```
```text
when@test:
  security:
    password_hashers:
      Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface:
        algorithm: auto
        cost: 4
        time_cost: 3
        memory_cost: 10
```