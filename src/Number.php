<?php
/**
 * Number
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2024 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Number
 */

namespace Pronamic\WordPress\Number;

use JsonSerializable;
use Pronamic\WordPress\Number\Calculator\BcMathCalculator;
use Pronamic\WordPress\Number\Calculator\PhpCalculator;

/**
 * Number
 *
 * @link https://psalm.dev/docs/annotating_code/type_syntax/scalar_types/#numeric-string
 * @author Remco Tolsma
 * @version 1.0.0
 * @since 1.0.0
 */
class Number implements JsonSerializable {
	/**
	 * Amount value.
	 *
	 * @psalm-var numeric-string
	 * @var string
	 */
	private $value;

	/**
	 * Calculator.
	 *
	 * @var Calculator|null
	 */
	private static $calculator;

	/**
	 * Calculators.
	 *
	 * @psalm-var array<int, class-string<Calculator>>
	 * @var array<int, string>
	 */
	private static $calculators = [
		BcMathCalculator::class,
		PhpCalculator::class,
	];

	/**
	 * Construct and initialize number object.
	 *
	 * @param mixed $value Value.
	 */
	public function __construct( $value ) {
		$this->set_value( $value );
	}

	/**
	 * Format i18n.
	 *
	 * @link https://developer.wordpress.org/reference/functions/number_format_i18n/
	 * @param int $decimals Precision of the number of decimal places.
	 * @return string
	 */
	public function format_i18n( $decimals = 0 ) {
		/**
		 * The WordPress `number_format_i18n` function requires a float but
		 * passing in a numeric string seems to work too.
		 *
		 * @psalm-suppress InvalidScalarArgument Passing a numeric string instead of a float doesn't seem to cause any problems.
		 * @phpstan-ignore-next-line
		 */
		return \number_format_i18n( $this->get_value(), $decimals );
	}

	/**
	 * Format number with internationalization and without trailing zeros.
	 *
	 * @return string
	 */
	public function format_i18n_non_trailing_zeros() {
		$value = $this->get_value();

		$decimals = 0;

		$decimal_pos = \strpos( $value, '.' );

		if ( false !== $decimal_pos ) {
			$decimal_part = \substr( $value, $decimal_pos + 1 );

			$decimals = \strlen( \rtrim( $decimal_part, '0' ) );
		}

		return $this->format_i18n( $decimals );
	}

	/**
	 * Format.
	 *
	 * @param int         $decimals            Precision of the number of decimal places.
	 * @param string|null $decimal_separator   Sets the separator for the decimal point.
	 * @param string|null $thousands_separator Sets the thousands separator.
	 * @return string
	 */
	public function format( $decimals = 0, $decimal_separator = '.', $thousands_separator = ',' ) {
		/**
		 * The PHP `number_format` function requires a float but
		 * passing in a numeric string seems to work too.
		 *
		 * @psalm-suppress InvalidScalarArgument Passing a numeric string instead of a float doesn't seem to cause any problems.
		 * @psalm-suppress PossiblyNullArgument According to the PHP documentation the decimal and thousands separtor can be null.
		 * @phpstan-ignore-next-line
		 */
		return \number_format( $this->get_value(), $decimals, $decimal_separator, $thousands_separator );
	}

	/**
	 * Get value.
	 *
	 * @psalm-return numeric-string
	 * @return string Numeric string value.
	 */
	public function get_value() {
		return $this->value;
	}

	/**
	 * Set value.
	 *
	 * @param mixed $value Amount value.
	 * @return void
	 */
	final public function set_value( $value ) {
		$this->value = self::parse_mixed( $value );
	}

	/**
	 * Returns a new Number object that represents
	 * the sum of this and an other Money object.
	 *
	 * @param Number $addend Addend.
	 * @return Number
	 */
	public function add( Number $addend ) {
		$calculator = $this->get_calculator();

		return $calculator->add( $this, $addend );
	}

	/**
	 * Returns a new Number object that represents
	 * the difference of this and an other Number object.
	 *
	 * @link https://github.com/moneyphp/money/blob/v3.2.1/src/Money.php#L235-L255
	 * @param Number $subtrahend Subtrahend.
	 * @return Number
	 */
	public function subtract( Number $subtrahend ) {
		$calculator = $this->get_calculator();

		return $calculator->subtract( $this, $subtrahend );
	}

	/**
	 * Returns a new Number object that represents
	 * the multiplied value of this Number object.
	 *
	 * @link https://github.com/moneyphp/money/blob/v3.2.1/src/Money.php#L299-L316
	 * @param Number $multiplier Multiplier.
	 * @return Number
	 */
	public function multiply( Number $multiplier ) {
		$calculator = $this->get_calculator();

		return $calculator->multiply( $this, $multiplier );
	}

	/**
	 * Returns a new Number object that represents
	 * the divided value of this Number object.
	 *
	 * @link https://github.com/moneyphp/money/blob/v3.2.1/src/Money.php#L318-L341
	 * @param Number $divisor Divisor.
	 * @return Number
	 */
	public function divide( Number $divisor ) {
		$calculator = $this->get_calculator();

		return $calculator->divide( $this, $divisor );
	}

	/**
	 * Returns the absolute number.
	 *
	 * @link https://github.com/moneyphp/money/blob/v3.2.1/src/Money.php#L318-L341
	 * @return Number
	 */
	public function absolute() {
		$calculator = $this->get_calculator();

		return $calculator->absolute( $this );
	}

	/**
	 * Checks if the value represented by this object is zero.
	 *
	 * @link https://github.com/moneyphp/money/blob/v4.0.1/src/Money.php#L425-L431
	 * @return bool True if zero, false otherwise.
	 */
	public function is_zero() {
		$calculator = $this->get_calculator();

		return 0 === $calculator->compare( $this, new self( '0' ) );
	}

	/**
	 * Negative.
	 *
	 * @link https://github.com/pronamic/wp-number/issues/1
	 * @return Number
	 */
	public function negative() {
		return self::from_int( 0 )->subtract( $this );
	}

	/**
	 * Is whole number?
	 *
	 * @return bool
	 */
	public function is_whole_number() {
		return (float) $this->to_int() === (float) $this->get_value();
	}

	/**
	 * JSON serialize.
	 *
	 * @link https://www.php.net/manual/en/jsonserializable.jsonserialize.php
	 * @return string
	 */
	public function jsonSerialize(): string {
		return $this->value;
	}

	/**
	 * Create int representation of this number object.
	 *
	 * @return int
	 */
	public function to_int() {
		return (int) $this->value;
	}

	/**
	 * Create a string representation of this number object.
	 *
	 * @psalm-return numeric-string
	 * @return string
	 */
	public function __toString() {
		return $this->get_value();
	}

	/**
	 * Initialize calculator.
	 *
	 * @return Calculator
	 *
	 * @throws \RuntimeException If cannot find calculator for number calculations.
	 */
	private static function initialize_calculator() {
		$calculator_classes = self::$calculators;

		foreach ( $calculator_classes as $calculator_class ) {
			if ( $calculator_class::supported() ) {
				$calculator = new $calculator_class();

				/**
				 * This should always be a `Calculator`, but we're checking
				 * this for now just to be sure.
				 *
				 * @psalm-suppress RedundantConditionGivenDocblockType
				 */
				if ( $calculator instanceof Calculator ) {
					return $calculator;
				}
			}
		}

		throw new \RuntimeException( 'Cannot find calculator for number calculations' );
	}

	/**
	 * Get calculator.
	 *
	 * @return Calculator
	 */
	protected function get_calculator() {
		if ( null === self::$calculator ) {
			self::$calculator = self::initialize_calculator();
		}

		return self::$calculator;
	}

	/**
	 * Create number from integer;
	 *
	 * @param int $value Value.
	 * @return self
	 */
	public static function from_int( $value ) {
		return new self( self::parse_int( $value ) );
	}

	/**
	 * Create number from float.
	 *
	 * @param float $value Value.
	 * @return self
	 */
	public static function from_float( $value ) {
		return new self( self::parse_float( $value ) );
	}

	/**
	 * Create number from string.
	 *
	 * @param string $value Value.
	 * @return self
	 */
	public static function from_string( $value ) {
		return new self( self::parse_string( $value ) );
	}

	/**
	 * Create number from mixed;
	 *
	 * @param mixed $value Value.
	 * @return self
	 */
	public static function from_mixed( $value ) {
		if ( $value instanceof self ) {
			return $value;
		}

		return new self( self::parse_mixed( $value ) );
	}

	/**
	 * Parse int.
	 *
	 * @param int $value Value.
	 * @psalm-return numeric-string
	 * @return string
	 * @throws \InvalidArgumentException Throws invalid argument exception when no integer is passed.
	 */
	private static function parse_int( $value ) {
		/**
		 * This should always be a `int`, but we're checking this for now just to be sure.
		 *
		 * @psalm-suppress DocblockTypeContradiction Ignore because we support older PHP versions and have not enabled strict types.
		 */
		if ( ! \is_int( $value ) ) {
			throw new \InvalidArgumentException(
				\sprintf(
					'Number::parse_int() function only accepts integers. Input was: %s',
					\esc_html( (string) \wp_json_encode( $value ) )
				)
			);
		}

		return self::parse_string( \strval( $value ) );
	}

	/**
	 * Parse float.
	 *
	 * @link https://www.php.net/manual/en/language.types.float.php
	 * @param float $value Value.
	 * @psalm-return numeric-string
	 * @return string
	 * @throws \InvalidArgumentException Throws invalid argument exception when no float is passed.
	 */
	private static function parse_float( $value ) {
		/**
		 * This should always be a `float`, but we're checking this for now just to be sure.
		 *
		 * @psalm-suppress DocblockTypeContradiction Ignore because we support older PHP versions and have not enabled strict types.
		 */
		if ( ! \is_float( $value ) ) {
			throw new \InvalidArgumentException(
				\sprintf(
					'Number::from_float() function only accepts floats. Input was: %s',
					\esc_html( (string) \wp_json_encode( $value ) )
				)
			);
		}

		/**
		 * The size of a float is platform-dependent, although a maximum of
		 * approximately 1.8e308 with a precision of roughly 14 decimal digits
		 * is a common value (the 64 bit IEEE format).
		 *
		 * We used `\sprintf( '%.14F', $value )` before, but `wp_json_encode`
		 * was giving better results.
		 *
		 * @link https://www.php.net/manual/en/language.types.float.php
		 * @link https://www.php.net/manual/en/function.sprintf.php
		 * @link https://www.php.net/manual/en/ini.core.php#ini.serialize-precision
		 * @link https://wiki.php.net/rfc/locale_independent_float_to_string
		 * @link https://stackoverflow.com/questions/48205572/json-encode-float-precision-in-php7-and-addition-operation
		 * @link https://bugs.php.net/bug.php?id=75800
		 */
		return self::parse_float_with_precision( $value, -1 );
	}

	/**
	 * Parse float precission.
	 *
	 * @codeCoverageIgnore
	 * @param float $value     Value.
	 * @param int   $precision Precision.
	 * @psalm-return numeric-string
	 * @return string
	 */
	public static function parse_float_with_precision( $value, $precision ) {
		$option = 'serialize_precision';

		/**
		 * The `serialize_precision` option was introduced in PHP 7.1.
		 *
		 * @link https://wiki.php.net/rfc/precise_float_value
		 */
		if ( \version_compare( \PHP_VERSION, '7.1', '<' ) ) {
			$option = 'precision';
		}

		// phpcs:ignore WordPress.PHP.IniSet.Risky
		$ini_serialize_precision = \ini_set( $option, (string) $precision );

		$result = self::parse_mixed( \wp_json_encode( $value ) );

		if ( false !== $ini_serialize_precision ) {
			// phpcs:ignore WordPress.PHP.IniSet.Risky
			\ini_set( $option, $ini_serialize_precision );
		}

		return $result;
	}

	/**
	 * Parse a string value.
	 *
	 * @link https://github.com/moneyphp/money/blob/v4.0.1/src/Number.php#L38-L46
	 * @link https://www.php.net/manual/en/language.types.numeric-strings.php
	 * @param string $value Value.
	 * @psalm-return numeric-string
	 * @return string
	 * @throws \InvalidArgumentException Throws invalid argument exception when no numeric value is passed.
	 */
	private static function parse_string( $value ) {
		if ( \is_numeric( $value ) ) {
			return $value;
		}

		throw new \InvalidArgumentException(
			\sprintf(
				'No numerical value: %s.',
				\esc_html( $value )
			)
		);
	}

	/**
	 * Parse mixed.
	 *
	 * @param mixed $value Value.
	 * @psalm-return numeric-string
	 * @return string
	 * @throws \InvalidArgumentException Throws invalid argument exception when an unsupported type is passed.
	 */
	private static function parse_mixed( $value ) {
		if ( $value instanceof Number ) {
			return $value->get_value();
		}

		if ( \is_int( $value ) ) {
			return self::parse_int( $value );
		}

		if ( \is_float( $value ) ) {
			return self::parse_float( $value );
		}

		if ( \is_string( $value ) ) {
			return self::parse_string( $value );
		}

		throw new \InvalidArgumentException(
			\sprintf(
				'Unsupported type, input was of type: %s.',
				\esc_html( \gettype( $value ) )
			)
		);
	}

	/**
	 * Normalize.
	 *
	 * @param string $value Value.
	 * @return string
	 */
	public static function normalize( $value ) {
		/**
		 * If the number value contains a decimal separator
		 * trim the trailing zeros and optiional the
		 * decimal separator.
		 *
		 * @link https://www.php.net/manual/en/function.bcscale.php#107259
		 */
		if ( false !== \strpos( $value, '.' ) ) {
			$value = \rtrim( $value, '0' );
			$value = \rtrim( $value, '.' );
		}

		return $value;
	}
}
