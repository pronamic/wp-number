<?php
/**
 * Number
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2021 Pronamic
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
 * @author Remco Tolsma
 * @version 1.0.0
 * @since 1.0.0
 */
class Number implements JsonSerializable {
	/**
	 * Amount value.
	 *
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
	 * @var array<int, string>
	 */
	private static $calculators = array(
		BcMathCalculator::class,
		PhpCalculator::class,
	);

	/**
	 * Construct and initialize number object.
	 *
	 * @param string|int|float $value Value.
	 */
	public function __construct( $value = 0 ) {
		$this->set_value( $value );
	}

	/**
	 * Format i18n.
	 *
	 * @link https://developer.wordpress.org/reference/functions/number_format_i18n/
	 * @param string|null $format Format.
	 * @return string
	 */
	public function format_i18n( $decimals = 0 ) {
		return \number_format_i18n( $this->get_value(), $decimals );
	}

	/**
	 * Format.
	 *
	 * @param string|null $format Format.
	 *
	 * @return string
	 */
	public function format( $decimals = 0, $decimal_separator = '.', $thousands_separator = ',' ) {
		return \number_format( $this->get_value(), $decimals, $decimal_separator, $thousands_separator );
	}

	/**
	 * Get value.
	 *
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
	public function set_value( $value ) {
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
	 * JSON serialize.
	 * 
	 * @link https://www.php.net/manual/en/jsonserializable.jsonserialize.php
	 * @return string
	 */
	public function jsonSerialize() {
		return $this->value;
	}

	/**
	 * Create a string representation of this number object.
	 *
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
	 */
	public static function from_int( $value ) {
		return new self( $value );
	}

	/**
	 * Create number from float.
	 * 
	 * @param float $value Value.
	 */
	public static function from_float( $value ) {
		return new self( $value );
	}

	/**
	 * Create number from string.
	 * 
	 * @param string $value Value.
	 */
	public static function from_string( $value ) {
		return new self( $value );
	}

	/**
	 * Create number from mixed;
	 * 
	 * @param mixed $value Value.
	 */
	public static function from_mixed( $value ) {
		return new self( $value );
	}

	/**
	 * Parse int.
	 * 
	 * @param int $value Value.
	 * @return string
	 */
	private static function parse_int( $value ) {
		if ( ! \is_int( $value ) ) {
			throw new \InvalidArgumentException(
				\sprintf(
					'Number::parse_int() function only accepts integers. Input was: %s',
					$value
				)
			);
		}

		return \strval( $value );
	}

	/**
	 * Parse float.
	 * 
	 * @link https://www.php.net/manual/en/language.types.float.php
	 * @param float $value Value.
	 * @return string
	 */
	private static function parse_float( $value ) {
		if ( ! \is_float( $value ) ) {
			throw new \InvalidArgumentException(
				\sprintf(
					'Number::from_float() function only accepts floats. Input was: %s',
					$value
				)
			);
		}

		/**
		 * The size of a float is platform-dependent, although a maximum of 
		 * approximately 1.8e308 with a precision of roughly 14 decimal digits
		 * is a common value (the 64 bit IEEE format).
		 * 
		 * @link https://www.php.net/manual/en/language.types.float.php
		 * @link https://www.php.net/manual/en/function.sprintf.php
		 */
		return self::normalize( \sprintf( '%.14F', $value ) );
	}

	/**
	 * Parse a string value.
	 * 
	 * @link https://github.com/moneyphp/money/blob/v4.0.1/src/Number.php#L38-L46
	 * @link https://www.php.net/manual/en/language.types.numeric-strings.php
	 */
	private static function parse_string( $value ) {
		if ( \is_numeric( $value ) ) {
			return $value;
		}

		throw new \InvalidArgumentException(
			\sprintf(
				'No numerical value: %s.',
				$value
			)
		);
	}

	/**
	 * Parse mixed.
	 * 
	 * @param mixed $value Value.
	 * @return string
	 */
	private static function parse_mixed( $value ) {
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
				\gettype( $value )
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
