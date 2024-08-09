<?php
/**
 * Calculator
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2024 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Number
 */

namespace Pronamic\WordPress\Number;

/**
 * Calculator
 *
 * @author Remco Tolsma
 * @version 1.0.0
 * @since 1.0.0
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
	 * @param Number $number Number.
	 * @param Number $addend Addend.
	 * @return Number
	 */
	public function add( Number $number, Number $addend );

	/**
	 * Subtract subtrahend from amount.
	 *
	 * @link https://github.com/moneyphp/money/blob/v3.2.1/src/Calculator.php#L40-L48
	 * @param Number $number     Number.
	 * @param Number $subtrahend Subtrahend.
	 * @return Number
	 */
	public function subtract( Number $number, Number $subtrahend );

	/**
	 * Multiply amount with multiplier.
	 *
	 * @link https://github.com/moneyphp/money/blob/v3.2.1/src/Calculator.php#L50-L58
	 * @param Number $number     Number.
	 * @param Number $multiplier Multiplier.
	 * @return Number
	 */
	public function multiply( Number $number, Number $multiplier );

	/**
	 * Divide amount with divisor.
	 *
	 * @link https://github.com/moneyphp/money/blob/v3.2.1/src/Calculator.php#L60-L68
	 * @param Number $number  Number.
	 * @param Number $divisor Divisor.
	 * @return Number
	 */
	public function divide( Number $number, Number $divisor );

	/**
	 * Absolute.
	 *
	 * @link https://github.com/moneyphp/money/blob/v4.0.1/src/Calculator/BcMathCalculator.php#L91-L99
	 * @param Number $number Number.
	 * @return Number
	 */
	public function absolute( Number $number );

	/**
	 * Compare.
	 *
	 * @link https://github.com/moneyphp/money/blob/v3.3.1/src/Calculator.php#L20-L28
	 * @link https://github.com/moneyphp/money/blob/v3.3.1/src/Calculator/BcMathCalculator.php#L35-L41
	 * @param Number $a Number A.
	 * @param Number $b Number B.
	 * @return int
	 */
	public function compare( Number $a, Number $b );
}
