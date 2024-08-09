<?php
/**
 * BC Math Calculator
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2024 Pronamic
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
	 * @param Number $number     Number.
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
	 * @return Number
	 * @throws \InvalidArgumentException Division by zero.
	 */
	public function divide( Number $number, Number $divisor ) {
		if ( $divisor->is_zero() ) {
			throw new \InvalidArgumentException( 'Division by zero' );
		}

		$result = \bcdiv( $number->get_value(), $divisor->get_value(), $this->scale );

		// @codeCoverageIgnoreStart
		if ( null === $result ) {
			throw new \InvalidArgumentException( 'Division by zero' );
		}
		// @codeCoverageIgnore

		return self::number( $result );
	}

	/**
	 * Absolute.
	 *
	 * @link https://github.com/moneyphp/money/blob/v4.0.1/src/Calculator/BcMathCalculator.php#L91-L99
	 * @param Number $number Number.
	 * @return Number
	 */
	public function absolute( Number $number ) {
		return self::number( \ltrim( $number->get_value(), '-' ) );
	}

	/**
	 * Compare.
	 *
	 * @link https://github.com/moneyphp/money/blob/v3.3.1/src/Calculator.php#L20-L28
	 * @link https://github.com/moneyphp/money/blob/v3.3.1/src/Calculator/BcMathCalculator.php#L35-L41
	 * @param Number $a Number A.
	 * @param Number $b Number B.
	 * @return int
	 */
	public function compare( Number $a, Number $b ) {
		return \bccomp( $a->get_value(), $b->get_value(), $this->scale );
	}
}
