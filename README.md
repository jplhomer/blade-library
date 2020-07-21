# Develop your Blade components in-browser.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jplhomer/blade-library.svg?style=flat-square)](https://packagist.org/packages/jplhomer/blade-library)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/jplhomer/blade-library/run-tests?label=tests)](https://github.com/jplhomer/blade-library/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/jplhomer/blade-library.svg?style=flat-square)](https://packagist.org/packages/jplhomer/blade-library)


## Installation

You can install the package via composer:

```bash
composer require jplhomer/blade-library
```

Then publish assets and configuration with:

```bash
php artisan blade-library:install
```

You can publish the views with:
```bash
php artisan vendor:publish --provider="BladeLibrary\BladeLibraryServiceProvider" --tag="blade-library-views"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

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
