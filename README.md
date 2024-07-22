# ZooArcadia-symfony

## Documentation

## Installation instructions

### Project requirements

- [PHP >=8.1 or higher](http://php.net/manual/fr/install.php)
- [SQL >=8.0](https://www.mysql.com/fr/downloads/)
- [Symfony CLI](https://symfony.com/download)
- [Composer](https://getcomposer.org/download)
- [Git](https://git-scm.com/book/en/v2/Getting-Started-Installing-Git)
- PHP extensions such as : JSON, Tokenizer and the [usual Symfony application requirements](https://symfony.com/doc/current/reference/requirements.html).

```bash
$ symfony check:requirements # To check minimal requirements for the project
```

### Installation

1 . **Register a GPG/SSH Key into your Gitlab/Github account** to push verified commits and registry images.

2 . Clone the current repository (SSH):

```bash
$ git clone 'https://github.com/cecilezan/ZooArcadia_Symfony.git'
```

3 . Move in and create few `.env.{environment}.local` files, according to your environments with your default configuration. **.local files are not committed to the shared repository.**

```bash
$ cp .env .env.local   # Create .env.$APP_ENV.local files. Complete them with your configuration.
```

4 . Set your DATABASE_URL in `.env.{environment}.local` files and run these commands :

```bash
$ composer install        # Install all PHP packages
$ php bin/console d:d:c   # Create your DATABASE related to your .env.local configuration
$ php bin/console d:m:m   # Run migrations to setup your DATABASE according to your entities
```

## Usage

```bash
$ symfony server:start    # Use this command to start a local server.
```
