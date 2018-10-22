Laravel SQLAnyWhere
============

Adds an Sybase driver to Laravel 4, usable with Fluent and Eloquent.

#Importante!
Ainda tem alguns BUGs em relação ao Schema para criar e modificar tabelas.

#Todo
    - Integração com Migrate, não está 100% :/
    - Testes para encontrar Bugs


Installation
============

Add `cagartner\laravel-sqlanywhere` and `cagartner/sql-anywhere-client` as a requirement to composer.json:

```javascript
{
    "require": {
        "cagartner/sql-anywhere-client": "dev-master",
        "cagartner/laravel-sqlanywhere": "dev-master"
    }
}
```

Update your packages with `composer update` or install with `composer install`.

Once Composer has installed or updated your packages you need to register 
LaravelODBC and the package it uses (extradb) with Laravel itself. 
Open up `app/config/app.php` and 
find the providers key towards the bottom.


 Add the following to the list of providers:
```php
'Cagartner\SQLAnywhere\SQLAnywhereServiceProvider',
```

You won't need to add anything to the aliases section.


Configuration
=============

There is no separate package configuration file for LaravelODBC.  You'll just add a new array to the `connections` array in `app/config/database.php`.

```
		'sqlanywhere' => array(
            'host'        => 'tcpip{host=Carlos.bludata.local;port=2638}',
            'username'    => 'teste-conexao',
            'password'    => 'teste',
            'database'    => 'teste-conexao',
            'auto_commit' => true,
            'persintent'  => false,
            'charset'     => 'utf8',
        ),
```

The ODBC driver is different from the pre-installed ones in that you're going to pass in the DSN instead of having Laravel build it for you.  There are just too many ways to configure an ODBC database for this package to do it for you.
Some sample configurations are at [php.net](http://php.net/manual/en/ref.pdo-odbc.connection.php).

**Don't forget to update your default database connection.**
