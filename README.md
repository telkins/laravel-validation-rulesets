# A simple way to keep your Laravel validation rules a bit more DRY.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/telkins/laravel-validation-rulesets.svg?style=flat-square)](https://packagist.org/packages/telkins/laravel-validation-rulesets)
[![Build Status](https://img.shields.io/travis/telkins/laravel-validation-rulesets/master.svg?style=flat-square)](https://travis-ci.org/telkins/laravel-validation-rulesets)
[![Quality Score](https://img.shields.io/scrutinizer/g/telkins/laravel-validation-rulesets.svg?style=flat-square)](https://scrutinizer-ci.com/g/telkins/laravel-validation-rulesets)
[![Total Downloads](https://img.shields.io/packagist/dt/telkins/laravel-validation-rulesets.svg?style=flat-square)](https://packagist.org/packages/telkins/laravel-validation-rulesets)


This package provides a relatively simple way to organize, reuse, and DRY up your Laravel validation rules.  It was put together after working with Laravel for quite some time and specifically while building an API that also uses Laravel Nova to manage resources.  There was a need to provide validation on the Laravel Nova side of things on a field-by-field basis.  Then, on the API side of things, there was also a need to provide those same validation rules.  These could be on a field-by-field basis or by resource.

So, by using this package, one can create two kinds of reusable rule sets.  The first kind of rule set is what is referred to as a field rule set.  A field rule set is a class implements the `Illuminate\Contracts\Validation\Rule` interface.  It can contain any number of Laravel's validation rules, as well as any other rule that implements `Illuminate\Contracts\Validation\Rule`.

The second kind of rule set is what is referred to as a resource rule set.  This doesn't really have any direct relationship to anything that currently exists within Laravel.  Rather, it's a convenient way to group rules for a given resource.  It provides rules common to updating and creating as well as creation- and update-specific rules.  This is quite similar to how Laravel Nova behaves with individual fields.  Currently, the creation and update rules merge in any common rules, again, in the same way that Laravel Nova does with resource fields.

The result of these new classes is that one can more easily put field- and resource-specific rules in individual classes, which can then be used, reused, and tested in a way that many might prefer.

## Installation

You can install the package via composer:

```bash
composer require telkins/laravel-validation-rulesets
```

## Field Rule Sets

A field rule set is a intended to be a validation rule object that can be applied or used for validating a single field or attribute.  It's similar to Laravel's validation objects that implement `Illuminate\Contracts\Validation\Rule`.  The main difference is that these field rule sets allow a user to list one or more validation rules in a set that will be applied to the field or attribute.  The code itself is inspired by Juampi Barreto's medium.com article, ["Laravel 5.5 validation ruleception (rule inside rule)"](https://medium.com/@juampi92/laravel-5-5-validation-ruleception-rule-inside-rule-2762d2cf4471).

Many times the same handful of validation rules need to be applied to a given field, like an email address or a password or something.  It's certainly easy enough to enter `'required|email|max:255`' each time it's needed.  It's also possible to create a validation rule that simply implements `Illuminate\Contracts\Validation\Rule`, but this requires writing all of the various validation code oneself, even though it's already there in the Laravel framework.

So, now one can simply create a new field rule set, and then provide the various validation rules that should apply.  This class is now quite portable and reusable as well as easily testable.

### Making a new field rule set

The package includes an artisan command to create a new field rule set.

```bash
php artisan make:field-rule-set NewEmail
```

This field rule set will have the `App\Rules\FieldRuleSets` namespace and will be saved in `app/Rules/FieldRuleSets`.

You can also indicate a custom namespace like `App\MyFieldRules`, for example:

```bash
php artisan make:field-rule-set MyFieldRules/NewEmail
```

This field rule set will have the `App\MyFieldRules` namespace and will be saved in `app/MyFieldRules`.

In any case, you should wind up with a file that looks similar to this:

```php
<?php

namespace App\Rules\FieldRuleSets;

use Telkins\Validation\AbstractFieldRuleSet;

class NewEmail extends AbstractFieldRuleSet
{
    public function rules() : array
    {
        return [
            // ...
        ];
    }
}
```

One simply fills in the various validation rules that should be used to apply to field when used.  For example:

```php
public function rules() : array
{
    return [
        'required',
        'email',
        'max:255',
    ];
}
```

One can also use other field rule sets, any object that implements `Illuminate\Contracts\Validation\Rule`, or closures.  The only thing one must remember to do is to keep each rule as its own element in the array.

### Usage

To use a field rule set in a form request:

```php
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

```php
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

This is necessary when applying validation rules that require the greater context of the request that needs to be validated.  For example, if you wish to use the `confirmed` validation rule, then the object needs to be able to access *all* of the request attributes and their values.  Simply pass that data into the constructor.

### Testing

```bash
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
