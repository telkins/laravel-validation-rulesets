# A simple way to keep your Laravel validation rules a bit more DRY.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/telkins/laravel-validation-rulesets.svg?style=flat-square)](https://packagist.org/packages/telkins/laravel-validation-rulesets)
[![Build Status](https://img.shields.io/travis/telkins/laravel-validation-rulesets/master.svg?style=flat-square)](https://travis-ci.org/telkins/laravel-validation-rulesets)
[![Quality Score](https://img.shields.io/scrutinizer/g/telkins/laravel-validation-rulesets.svg?style=flat-square)](https://scrutinizer-ci.com/g/telkins/laravel-validation-rulesets)
[![Total Downloads](https://img.shields.io/packagist/dt/telkins/laravel-validation-rulesets.svg?style=flat-square)](https://packagist.org/packages/telkins/laravel-validation-rulesets)


This is where your description should go. Try and limit it to a paragraph or two.

## Installation

You can install the package via composer:

```bash
composer require telkins/laravel-validation-rulesets
```

## Field Rule Sets

### Making a new field rule set

The package includes an artisan command to create a new field rule set.

```bash
php artisan make:field-rule-set NewEmail
```

This field rule set will have the `App\Rules\FieldRuleSets` namespace and will be saved in `app/Rules/FieldRuleSets`.

You can also indicate a custom namespace like `App\MyFieldRules`, for example:

```bash
php artisan make:rule-set MyFieldRules/NewEmail
```

This field rule set will have the `App\MyFieldRules` namespace and will be saved in `app/MyFieldRules`.

### Usage

To use a field rule set in a form request:

``` php
/**
 * Get the validation rules that apply to the request.
 *
 * @return array
 */
public function rules()
{
    return [
        'email_address' => new EmailAddressRuleSet(),
        'subject' => 'required|string|max:255',
        'message' => 'required|string',
    ];
}
```

To use a field rule set in a form request where it might require the whole request data context:

``` php
/**
 * Get the validation rules that apply to the request.
 *
 * @return array
 */
public function rules()
{
    return [
        'email_address' => new EmailAddressRuleSet($this->all()),
        'subject' => 'required|string|max:255',
        'message' => 'required|string',
    ];
}
```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Travis Elkins](https://github.com/telkins)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
