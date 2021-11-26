# Purpose

This project demonstrates Symfony Serializer bug: https://github.com/symfony/symfony/issues/44273

# Reproducing the error

```shell
composer update
vendor/bin/phpunit
```


Notice Serializer tries to access special `$initializer<unique-id>` property.

# Switching back to older version of symfony/serializer

```shell
composer update --with=symfony/serializer:5.3.10
vendor/bin/phpunit
```
