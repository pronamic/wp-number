<?php
/**
 * Number Test
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2021 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Money
 */

namespace Pronamic\WordPress\Number;

/**
 * Number Test
 *
 * @author Remco Tolsma
 * @version 1.0.0
 * @since 1.0.0
 */
class NumberTest extends \WP_UnitTestCase {
	/**
	 * Test add.
	 *
	 * @since 1.0.0
	 */
	public function test_add() {
		$number_1 = new Number( 99.75 );

		$number_2 = new Number( 0.25 );

		$number_3 = $number_1->add( $number_2 );

		$this->assertEquals( 100, $number_3->get_value() );
	}
}
