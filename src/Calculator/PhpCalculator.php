<?php
/**
 * PHP Calculator
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
 * PHP Calculator
 *
 * @author  Remco Tolsma
 * @version 1.2.2
 * @since   1.2.2
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
	public function multiply( $number, $multiplier ) {
		return Number::from_mixed( $number->get_value() * $multiplier->get_value() );
	}

	/**
	 * {@inheritdoc}
	 *
	 * @link https://github.com/moneyphp/money/blob/v3.2.1/src/Calculator/PhpCalculator.php#L66-L76
	 *
	 * @param Number $number  Value.
	 * @param Number $divisor Divisor.
	 *
	 * @return Number
	 */
	public function divide( $number, $divisor ) {
		return Number::from_mixed( $number->get_value() / $divisor->get_value() );
	}
}
