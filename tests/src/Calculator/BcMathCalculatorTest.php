<?php
/**
 * BC Math Calculator Test
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2022 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Money
 */

namespace Pronamic\WordPress\Number\Calculator;

use Pronamic\WordPress\Number\Number;

/**
 * BC Math Calculator Test
 *
 * @author Remco Tolsma
 * @version 1.0.0
 * @since 1.0.0
 */
class BcMathCalculatorTest extends CalculatorTestCase {
	/**
	 * Get calculator.
	 */
	public function get_calculator() {
		return new BcMathCalculator();
	}
}
