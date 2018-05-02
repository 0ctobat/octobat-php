# Octobat PHP bindings

You can sign up for an Octobat account at https://www.octobat.com.

## Requirements

PHP 5.4.0 and later.

## Composer

You can install the bindings via [Composer](http://getcomposer.org/). Run the following command:

```bash
composer require 0ctobat/octobat-php
```

To use the bindings, use Composer's [autoload](https://getcomposer.org/doc/01-basic-usage.md#autoloading):

```php
require_once('vendor/autoload.php');
```

## Manual Installation

If you do not wish to use Composer, you can download the [latest release](https://github.com/0ctobat/octobat-php/releases). Then, to use the bindings, include the `init.php` file.

```php
require_once('/path/to/octobat-php/init.php');
```

## Dependencies

The bindings require the following extensions in order to work properly:

- [`curl`](https://secure.php.net/manual/en/book.curl.php), although you can use your own non-cURL client if you prefer
- [`json`](https://secure.php.net/manual/en/book.json.php)
- [`mbstring`](https://secure.php.net/manual/en/book.mbstring.php) (Multibyte String)

If you use Composer, these dependencies should be handled automatically. If you install manually, you'll want to make sure that these extensions are available.

## Getting Started

Simple usage looks like:

```php
\Octobat\Octobat::setApiKey('sk_test_BQokikJOvBiI2HlWgH4olfQ2');
$customer = \Octobat\Customer::create(['email' => "john.doe@gmail.com", 'name' => 'John Doe', 'billing_address_country' => 'FR']);
echo $customer;
```

## Documentation

Please see http://v2apidoc.octobat.com/ for up-to-date documentation.


### Configuring a Logger

The library does minimal logging, but it can be configured
with a [`PSR-3` compatible logger][psr3] so that messages
end up there instead of `error_log`:

```php
\Octobat\Octobat::setLogger($logger);
```



### Per-request Configuration

For apps that need to use multiple keys during the lifetime of a process, like
one that uses [Stripe Connect][connect], it's also possible to set a
per-request key and/or account:

```php
\Octobat\Customer::all([], [
    'api_key' => 'oc_test_skey...'
]);

\Octobat\Customer::retrieve("oc_cu_xxxxxxxx", [
    'api_key' => 'oc_test_skey...'
]);
```
