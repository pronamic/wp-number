<?php
/**
 * PHP Calculator Test
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2024 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Money
 */

namespace Pronamic\WordPress\Number\Calculator;

/**
 * PHP Calculator Test
 *
 * @author Remco Tolsma
 * @version 1.0.0
 * @since 1.0.0
 */
class PhpCalculatorTest extends CalculatorTestCase {
	/**
	 * Get calculator.
	 */
	public function get_calculator() {
		return new PhpCalculator();
	}
}
