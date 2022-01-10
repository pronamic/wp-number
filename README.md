<h1 align="center">Pronamic WordPress Number</h3>

<p align="center">
	WordPress Number library.
</p>

[![Latest Stable Version](http://poser.pugx.org/pronamic/wp-number/v)](https://packagist.org/packages/pronamic/wp-number)
[![Total Downloads](http://poser.pugx.org/pronamic/wp-number/downloads)](https://packagist.org/packages/pronamic/wp-number)
[![Latest Unstable Version](http://poser.pugx.org/pronamic/wp-number/v/unstable)](https://packagist.org/packages/pronamic/wp-number)
[![License](http://poser.pugx.org/pronamic/wp-number/license)](https://packagist.org/packages/pronamic/wp-number)
[![codecov](https://codecov.io/gh/pronamic/wp-number/branch/main/graph/badge.svg?token=NB3B1FS1CP)](https://codecov.io/gh/pronamic/wp-number)
[![Coverage Status](https://coveralls.io/repos/github/pronamic/wp-number/badge.svg?branch=main)](https://coveralls.io/github/pronamic/wp-number?branch=main)

## Table of contents

- [Getting Started](#getting-started)
- [Usage](#usage)
- [Design Principles](#design-principles)

## Getting Started

### Installation

```
composer require pronamic/wp-number
```

## Usage

```
$number = Number::from_float( 123.50 )->add( 0.45 );

echo \esc_html( $number->format_i18n( 2 ) );
```

## Design Principles

### A number is a number

> In general, a number is a number, not a string, and this means that any programming language treats a number as a number. Thus, the number by itself doesn't imply any specific format (like using .000021 instead of 2.1e-5). This is nothing different to displaying a number with leading zeros (like 0.000021) or aligning lists of numbers. This is a general issue you'll find in any programming language: if you want a specific format you need to specify it, using the format functions of your programming language.
> 
> Unless you specify the number as string and convert it to a real number when needed, of course. Some languages can do this implicitly.

https://stackoverflow.com/a/1471792

### Number in exponential form / scientific notation

> 2.1E-5 is the same number as 0.000021. That's how it prints numbers below 0.001. Use printf() if you want it in a particular format.
> 
> **Edit** If you're not familiar with the `2.1E-5` syntax, you should know it is shorthand for 2.1×10-5. It is how most programming languages represent numbers in scientific notation.

https://stackoverflow.com/a/1471694

### Leading zeros

In https://github.com/moneyphp/money it is not allowed to use leading zeros:

> Leading zeros are not allowed

_Source:_ https://github.com/moneyphp/money/search?q=leading+zero

This probably has somehting to do with the following user note:

> Be careful with GMP - it considers leading zeros in a number string as meaning the number is in octal, whereas 'bc' doesn't:
>
> `gmp_strval("000100", 10) => 64`
>
> `bcmul("000100", "1") => 100`

_Source:_ https://www.php.net/manual/en/book.gmp.php#106521

```php
<?php
$a = 1234; // decimal number
$a = 0123; // octal number (equivalent to 83 decimal)
$a = 0x1A; // hexadecimal number (equivalent to 26 decimal)
$a = 0b11111111; // binary number (equivalent to 255 decimal)
$a = 1_234_567; // decimal number (as of PHP 7.4.0)
?>
```

_Source:_ https://www.php.net/manual/en/language.types.integer.php

> A leading zero in a numeric literal means "this is octal". But don't be confused: a leading zero in a string does not. Thus:
> `$x = 0123;          // 83`
> `$y = "0123" + 0     // 123`

_Source:_ https://www.php.net/manual/en/language.types.integer.php#111523

## Links

- https://0.30000000000000004.com/

[![Pronamic - Work with us](https://github.com/pronamic/brand-resources/blob/main/banners/pronamic-work-with-us-leaderboard-728x90%404x.png)](https://www.pronamic.eu/contact/)
