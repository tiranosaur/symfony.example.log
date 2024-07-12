# SETTING


```text
composer require symfony/orm-pack && composer require symfony/validator && composer require doctrine/annotations && composer require orm-fixtures --dev && composer require doctrine/doctrine-fixtures-bundle --dev
```

1. Prepare envs + db

DATABASE_URL="mysql://root:@mysql-8.2:3306/symfony?charset=utf8"

```text
php bin/console doctrine:database:create
php bin/console make:migration
php bin/console doctrine:migrations:migrate
```

2. Create article

3. fill fixtures
```text
php bin/console doctrine:fixtures:load
php bin/console doctrine:fixtures:load --group=ArticleFixtures
```

4. test
!!!fixtures
!!! dama/doctrine-test-bundle сбрасывает прогресс
```textmate
composer require dama/doctrine-test-bundle --dev
```
```textmate 
php bin/console doctrine:database:drop --force --env=test
php bin/console doctrine:database:create --env=test
php bin/console doctrine:schema:create --env=test
php bin/console doctrine:fixtures:load --env=test
```