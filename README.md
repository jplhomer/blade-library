# Develop your Blade components in-browser.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jplhomer/woodblock.svg?style=flat-square)](https://packagist.org/packages/jplhomer/woodblock)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/jplhomer/woodblock/run-tests?label=tests)](https://github.com/jplhomer/woodblock/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/jplhomer/woodblock.svg?style=flat-square)](https://packagist.org/packages/jplhomer/woodblock)


## Installation

You can install the package via composer:

```bash
composer require jplhomer/woodblock
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="Woodblock\WoodblockServiceProvider" --tag="migrations"
php artisan migrate
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="Woodblock\WoodblockServiceProvider" --tag="config"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

``` php
$woodblock = new Woodblock();
echo $woodblock->echoPhrase('Hello, Woodblock!');
```

## Testing

``` bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email jplhomer@gmail.com instead of using the issue tracker.

## Credits

- [Josh Larson](https://github.com/jplhomer)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
