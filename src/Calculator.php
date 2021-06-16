<?php
/**
 * Calculator
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2021 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Number
 */

namespace Pronamic\WordPress\Number;

/**
 * Calculator
 *
 * @author  Remco Tolsma
 * @version 1.0.0
 * @since   1.0.0
 */
interface Calculator {
	/**
	 * Returns whether the calculator is supported in
	 * the current server environment.
	 *
	 * @link https://github.com/moneyphp/money/blob/v3.2.1/src/Calculator.php#L12-L18
	 *
	 * @return bool
	 */
	public static function supported();

	/**
	 * Add added to amount.
	 *
	 * @link https://github.com/moneyphp/money/blob/v3.2.1/src/Calculator.php#L30-L38
	 *
	 * @param Number $value  Value.
	 * @param Number $addend Addend.
	 *
	 * @return Number
	 */
	public function add( Number $value, Number $addend );

	/**
	 * Subtract subtrahend from amount.
	 *
	 * @link https://github.com/moneyphp/money/blob/v3.2.1/src/Calculator.php#L40-L48
	 *
	 * @param Number $value      Value.
	 * @param Number $subtrahend Subtrahend.
	 *
	 * @return Number
	 */
	public function subtract( Number $value, Number $subtrahend );

	/**
	 * Multiply amount with multiplier.
	 *
	 * @link https://github.com/moneyphp/money/blob/v3.2.1/src/Calculator.php#L50-L58
	 *
	 * @param Number $value      Value.
	 * @param Number $multiplier Multiplier.
	 *
	 * @return string
	 */
	public function multiply( Number $value, Number$multiplier );

	/**
	 * Divide amount with divisor.
	 *
	 * @link https://github.com/moneyphp/money/blob/v3.2.1/src/Calculator.php#L60-L68
	 *
	 * @param Number $value   Value.
	 * @param Number $divisor Divisor.
	 *
	 * @return Number
	 */
	public function divide( Number $value, Number $divisor );
}
