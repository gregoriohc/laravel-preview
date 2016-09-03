# Preview

[![Latest Version on Packagist](https://img.shields.io/packagist/v/gregoriohc/laravel-preview.svg?style=flat-square)](https://packagist.org/packages/gregoriohc/laravel-preview)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/gregoriohc/laravel-preview/master.svg?style=flat-square)](https://travis-ci.org/gregoriohc/laravel-preview)
[![StyleCI](https://styleci.io/repos/66579513/shield)](https://styleci.io/repos/66579513)
[![Quality Score](https://img.shields.io/scrutinizer/g/gregoriohc/laravel-preview.svg?style=flat-square)](https://scrutinizer-ci.com/g/gregoriohc/laravel-preview)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/gregoriohc/laravel-preview/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/gregoriohc/laravel-preview/?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/gregoriohc/laravel-preview.svg?style=flat-square)](https://packagist.org/packages/gregoriohc/laravel-preview)

**WARNING: USE THIS PACKAGE ONLY IN LOCAL/DEBUG MODE! ENABLING THIS PACKAGE IN PRODUCTION ENVIRONMENTS CAN REPRESENT A BIG SECURITY ISSUE!**

View preview package for Laravel

This package can be used to preview your laravel views without needing to create a route or controller to load the view. It can also be useful if you want to preview your emails views without needing to send them.

## Contents

- [Installation](#installation)
- [Usage](#usage)
- [Changelog](#changelog)
- [Testing](#testing)
- [Security](#security)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)

## Installation

You can install the package via composer:

``` bash
composer require gregoriohc/laravel-preview
```

You must install the service provider:

```php
// config/app.php
'providers' => [
    ...
    Gregoriohc\Preview\PreviewServiceProvider::class,
],
```

## Usage

Now, if you are in local environment with debug mode enabled, you can access the preview route.

The preview route path has the following structure: `/_preview/{view}?{params}`

The `{view}` can be any app or package view, using the dot and namespace notation of Laravel (ex.: welcome, errors.503, mypackage::myview)

For example, if you want to preview the Laravel default welcome page, you can go to: `/_preview/welcome`

The optional `{params}` can be a list of parameters that will be converted to variables and passed to the view. The key of the parameter will be the variable name, and the value will be transformed depending on its format. The possible formats are the following:

- Object from json: If you pass a json string, it will be automatically converted to an object. For example: `user={"name": "John Doe", "email": "johndoe@example.com"}`
- Model object: To load a model object, just pass (separated by `::`) the model class (with full namespace) and the object ID you are looking for. For example: `user=App\User::1`.
- Class method call: To call a class method, just pass (separated by `::`) the class (with full namespace), the method, and a list of params. For example: `appname=Config::get::app.name` or `something=MyClass::myMethod::param_1::param_2::param_3`. If the method is static, it will called statically, if not, a class object will be instantiated and the method will be called.
- On any other case, the value will be passed without changes

More examples:

- `/_preview/emails.user.welcome?user=App\User::1`
- `/_preview/admin.user.show?user=App\User::1`
- `/_preview/mypackage::my.fantastic.view?something=Cache::get::something&anotherthing=textcontent&somenumber=123`

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Security

If you discover any security related issues, please email gregoriohc@gmail.com instead of using the issue tracker.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Gregorio Hernández Caso](https://github.com/gregoriohc)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.