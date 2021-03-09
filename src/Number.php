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

use Pronamic\WordPress\Number\Calculator\BcMathCalculator;
use Pronamic\WordPress\Number\Calculator\PhpCalculator;

/**
 * Number
 *
 * @author Remco Tolsma
 * @version 1.0.0
 * @since   1.0.0
 */
class Number {
	/**
	 * Amount value.
	 *
	 * @var float
	 */
	private $value;

	/**
	 * Currency.
	 *
	 * @var Currency
	 */
	private $currency;

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
	 * @param string|int|float $value    Amount value.
	 * @param Currency|string  $currency Currency.
	 */
	public function __construct( $value = 0 ) {
		$this->set_value( $value );
	}

	/**
	 * Get default format.
	 *
	 * @return string
	 */
	public static function get_default_format() {
		/* translators: 1: currency symbol, 2: amount value, 3: currency code, note: use non-breaking space! */
		$format = _x( '%1$s%2$s %3$s', 'money format', 'pronamic-money' );
		// Note:               ↳ Non-breaking space.
		$format = apply_filters( 'pronamic_money_default_format', $format );

		return $format;
	}

	/**
	 * Format i18n.
	 *
	 * @param string|null $format Format.
	 *
	 * @return string
	 */
	public function format_i18n( $format = null ) {
		if ( is_null( $format ) ) {
			$format = self::get_default_format();
		}

		return number_format_i18n( $this->get_value(), 2 );
	}

	/**
	 * Format i18n without trailing zeros.
	 *
	 * @param string|null $format Format.
	 *
	 * @return string
	 */
	public function format_i18n_non_trailing_zeros( $format = null ) {
		if ( is_null( $format ) ) {
			$format = self::get_default_format();
		}

		$format = str_replace( '%2$s', '%2$NTZ', $format );

		return $this->format_i18n( $format );
	}

	/**
	 * Format.
	 *
	 * @param string|null $format Format.
	 *
	 * @return string
	 */
	public function format( $format = null ) {
		if ( is_null( $format ) ) {
			$format = '%2$s';
		}

		return number_format( $this->get_value(), 2, '.', '' );
	}

	/**
	 * Get value.
	 *
	 * @return float Amount value.
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
		$this->value = floatval( $value );
	}

	/**
	 * Create a string representation of this money object.
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->format_i18n();
	}

	/**
	 * Returns a new Number object that represents
	 * the sum of this and an other Money object.
	 *
	 * @param Number $addend Addend.
	 *
	 * @return Money
	 */
	public function add( Number $addend ) {
		$value = $this->get_value();

		$calculator = $this->get_calculator();

		// Use non-locale aware float value.
		$value  = \sprintf( '%F', $value );
		$addend = \sprintf( '%F', $addend->get_value() );

		$value = $calculator->add( $value, $addend );

		$result = clone $this;

		$result->set_value( $value );

		return $result;
	}

	/**
	 * Returns a new Number object that represents
	 * the difference of this and an other Number object.
	 *
	 * @link https://github.com/moneyphp/money/blob/v3.2.1/src/Money.php#L235-L255
	 *
	 * @param Number $subtrahend Subtrahend.
	 *
	 * @return Number
	 */
	public function subtract( Number $subtrahend ) {
		$value = $this->get_value();

		$calculator = $this->get_calculator();

		// Use non-locale aware float value.
		$value      = \sprintf( '%F', $value );
		$subtrahend = \sprintf( '%F', $subtrahend->get_value() );

		$value = $calculator->subtract( $value, $subtrahend );

		$result = clone $this;

		$result->set_value( $value );

		return $result;
	}

	/**
	 * Returns a new Number object that represents
	 * the multiplied value of this Number object.
	 *
	 * @link https://github.com/moneyphp/money/blob/v3.2.1/src/Money.php#L299-L316
	 *
	 * @param int|float|string $multiplier Multiplier.
	 *
	 * @return Number
	 */
	public function multiply( $multiplier ) {
		$value = $this->get_value();

		$calculator = $this->get_calculator();

		// Use non-locale aware float value.
		$value      = \sprintf( '%F', $value );
		$multiplier = \sprintf( '%F', $multiplier );

		$value = $calculator->multiply( $value, $multiplier );

		$result = clone $this;

		$result->set_value( $value );

		return $result;
	}

	/**
	 * Returns a new Number object that represents
	 * the divided value of this Number object.
	 *
	 * @link https://github.com/moneyphp/money/blob/v3.2.1/src/Money.php#L318-L341
	 *
	 * @param int|float|string $divisor Divisor.
	 *
	 * @return Number
	 */
	public function divide( $divisor ) {
		$value = $this->get_value();

		$calculator = $this->get_calculator();

		// Use non-locale aware float value.
		$value   = \sprintf( '%F', $value );
		$divisor = \sprintf( '%F', $divisor );

		$value = $calculator->divide( $value, $divisor );

		if ( null === $value ) {
			$value = $this->get_value();
		}

		$result = clone $this;

		$result->set_value( $value );

		return $result;
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
}
