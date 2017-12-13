[![Build Status](https://travis-ci.org/hollodotme/crontab-expression.svg?branch=master)](https://travis-ci.org/hollodotme/crontab-expression)
[![Latest Stable Version](https://poser.pugx.org/hollodotme/crontab-expression/v/stable)](https://packagist.org/packages/hollodotme/crontab-expression) 
[![Total Downloads](https://poser.pugx.org/hollodotme/crontab-expression/downloads)](https://packagist.org/packages/hollodotme/crontab-expression) 
[![Coverage Status](https://coveralls.io/repos/github/hollodotme/crontab-expression/badge.svg?branch=master)](https://coveralls.io/github/hollodotme/crontab-expression?branch=master)

# CrontabExpression

## Description

Library to validate crontab expressions and check their due date

## Requirements

* PHP >= 7.1

## Installation

```bash
composer require hollodotme/crontab-expression
```

## Usage

### Validate expressions

Expressions are validated on construction of `CrontabExpression`.  

If you provide an invalid expression a `hollodotme\CrontabValidator\Exceptions\InvalidExpressionException` will be thrown.

If you need boolean validation of crontab expressions, please use [hollodotme/crontab-validator](https://github.com/hollodotme/crontab-validator).
The `hollodotme/crontab-validator` package is a dependency for this package (hollodotme/crontab-expression), so you can also use the validator separately:

```php
<?php declare(strict_types=1);

namespace YourVendor\YourProject;

use hollodotme\CrontabValidator\CrontabValidator;

$validator = new CrontabValidator();

if ($validator->isExpressionValid('*/10 6-21 * * 1-5'))
{
	echo 'Expression is valid.';
}
else
{
	echo 'Expression is invalid.';
}
```

**Prints:**

```
Expression is valid.
```

### Check if date satisfies expression (expression is due)

```php
<?php declare(strict_types=1);

namespace YourVendor\YourProject;

use hollodotme\CrontabExpression\CrontabExpression;

$expression = new CrontabExpression('*/10 6-21 * * 1-5');

echo $expression->isDue(new \DateTimeImmutable('2017-12-13 16:30:00')) ? 'Is due.' : 'Is not due.';
echo $expression->isDue(new \DateTimeImmutable('2017-12-10 16:30:00')) ? 'Is due.' : 'Is not due.';

# If you omit the $dateTime parameter, new \DateTimeImmutable() - current date - will be used.
echo $expression->isDue() ? 'Depends on your current date & time. (DUE)' : 'Depends on your current date & time. (NOT DUE)';
```

**Prints:**

```
Is due.
Is not due.
Depends on your current date & time. (DUE|NOT DUE)
```

## Contributing

Contributions are welcome and will be fully credited. Please see the [contribution guide](.github/CONTRIBUTING.md) for details.


