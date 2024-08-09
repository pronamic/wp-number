<?php
/**
 * PHP Calculator
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
 * PHP Calculator
 *
 * @author Remco Tolsma
 * @version 1.0.0
 * @since 1.0.0
 */
class PhpCalculator implements Calculator {
	/**
	 * {@inheritdoc}
	 */
	public static function supported() {
		return true;
	}

	/**
	 * {@inheritdoc}
	 *
	 * @link https://github.com/moneyphp/money/blob/v3.2.1/src/Calculator/PhpCalculator.php#L30-L40
	 *
	 * @param Number $number Value.
	 * @param Number $addend Addend.
	 *
	 * @return Number
	 */
	public function add( Number $number, Number $addend ) {
		return Number::from_mixed( $number->get_value() + $addend->get_value() );
	}

	/**
	 * {@inheritdoc}
	 *
	 * @link https://github.com/moneyphp/money/blob/v3.2.1/src/Calculator/PhpCalculator.php#L42-L52
	 *
	 * @param Number $number     Value.
	 * @param Number $subtrahend Subtrahend.
	 *
	 * @return Number
	 */
	public function subtract( Number $number, Number $subtrahend ) {
		return Number::from_mixed( $number->get_value() - $subtrahend->get_value() );
	}

	/**
	 * {@inheritdoc}
	 *
	 * @link https://github.com/moneyphp/money/blob/v3.2.1/src/Calculator/PhpCalculator.php#L54-L64
	 *
	 * @param Number $number     Value.
	 * @param Number $multiplier Multiplier.
	 *
	 * @return Number
	 */
	public function multiply( Number $number, Number $multiplier ) {
		return Number::from_mixed( $number->get_value() * $multiplier->get_value() );
	}

	/**
	 * {@inheritdoc}
	 *
	 * @link https://github.com/moneyphp/money/blob/v3.2.1/src/Calculator/PhpCalculator.php#L66-L76
	 *
	 * @param Number $number  Value.
	 * @param Number $divisor Divisor.
	 * @return Number
	 * @throws \InvalidArgumentException Division by zero.
	 */
	public function divide( Number $number, Number $divisor ) {
		if ( $divisor->is_zero() ) {
			throw new \InvalidArgumentException( 'Division by zero' );
		}

		return Number::from_mixed( $number->get_value() / $divisor->get_value() );
	}

	/**
	 * Absolute.
	 *
	 * @link https://github.com/moneyphp/money/blob/v3.3.1/src/Calculator/PhpCalculator.php#L94-L104
	 * @param Number $number Number.
	 * @return Number
	 */
	public function absolute( Number $number ) {
		return Number::from_mixed( \ltrim( $number->get_value(), '-' ) );
	}

	/**
	 * Compare.
	 *
	 * @link https://github.com/moneyphp/money/blob/v3.3.1/src/Calculator.php#L20-L28
	 * @link https://github.com/moneyphp/money/blob/v3.3.1/src/Calculator/PhpCalculator.php#L22-L28
	 * @param Number $a Number A.
	 * @param Number $b Number B.
	 * @return int
	 */
	public function compare( Number $a, Number $b ) {
		$value_a = $a->get_value();
		$value_b = $b->get_value();

		if ( $value_a < $value_b ) {
			return -1;
		}

		if ( $value_a > $value_b ) {
			return 1;
		}

		return 0;
	}
}
