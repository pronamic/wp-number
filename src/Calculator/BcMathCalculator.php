<?php
/**
 * BC Math Calculator
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2021 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Number
 */

namespace Pronamic\WordPress\Number\Calculator;

use Pronamic\WordPress\Number\Calculator;
use Pronamic\WordPress\Number\Number;

/**
 * BC Math Calculator
 *
 * @author Remco Tolsma
 * @version 1.0.0
 * @since 1.0.0
 */
class BcMathCalculator implements Calculator {
	/**
	 * Scale.
	 *
	 * @var int
	 */
	private $scale;

	/**
	 * Construct BC Math Calculator.
	 *
	 * @param int $scale Scale.
	 */
	public function __construct( $scale = 14 ) {
		$this->scale = $scale;
	}

	/**
	 * {@inheritdoc}
	 */
	public static function supported() {
		return \extension_loaded( 'bcmath' );
	}

	/**
	 * Trim the trailing zeros caused by the high scale parameter value.
	 *
	 * @param string $value BC Math result value.
	 * @return Number
	 */
	private static function number( $value ) {
		return Number::from_string( Number::normalize( $value ) );
	}

	/**
	 * {@inheritdoc}
	 *
	 * @link https://github.com/moneyphp/money/blob/v3.2.1/src/Calculator/BcMathCalculator.php
	 *
	 * @param Number $number Number.
	 * @param Number $addend Addend.
	 *
	 * @return Number
	 */
	public function add( Number $number, Number $addend ) {
		return self::number( \bcadd( $number->get_value(), $addend->get_value(), $this->scale ) );
	}

	/**
	 * {@inheritdoc}
	 *
	 * @link https://github.com/moneyphp/money/blob/v3.2.1/src/Calculator/BcMathCalculator.php#L51-L62
	 *
	 * @param Number $value      Number.
	 * @param Number $subtrahend Subtrahend.
	 *
	 * @return Number
	 */
	public function subtract( Number $number, Number $subtrahend ) {
		return self::number( \bcsub( $number->get_value(), $subtrahend->get_value(), $this->scale ) );
	}

	/**
	 * {@inheritdoc}
	 *
	 * @link https://github.com/moneyphp/money/blob/v3.2.1/src/Calculator/BcMathCalculator.php#L64-L72
	 *
	 * @param Number $number     Number.
	 * @param Number $multiplier Multiplier.
	 *
	 * @return Number
	 */
	public function multiply( Number $number, Number $multiplier ) {
		return self::number( \bcmul( $number->get_value(), $multiplier->get_value(), $this->scale ) );
	}

	/**
	 * {@inheritdoc}
	 *
	 * @link https://github.com/moneyphp/money/blob/v3.2.1/src/Calculator/BcMathCalculator.php#L74-L82
	 * @link https://php.net/bcdiv
	 *
	 * @param Number $number  Number.
	 * @param Number $divisor Divisor.
	 *
	 * @return Number
	 */
	public function divide( Number $number, Number $divisor ) {
		return self::number( \bcdiv( $number->get_value(), $divisor->get_value(), $this->scale ) );
	}
}
