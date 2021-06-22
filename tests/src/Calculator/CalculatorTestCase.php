<?php
/**
 * PHP Calculator Test
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2021 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Money
 */

namespace Pronamic\WordPress\Number\Calculator;

use Pronamic\WordPress\Number\Number;

/**
 * PHP Calculator Test
 *
 * @author Remco Tolsma
 * @version 1.0.0
 * @since 1.0.0
 */
abstract class CalculatorTestCase extends \WP_UnitTestCase {
	/**
	 * @return Calculator
	 */
	abstract protected function get_calculator();

	/**
	 * Test supported.
	 */
	public function test_supported() {
		$calculator = $this->get_calculator();

		$this->assertTrue( $calculator->supported() );
	}

	/**
	 * Test add.
	 */
	public function test_add() {
		$calculator = $this->get_calculator();

		$number_1 = new Number( 99.75 );

		$number_2 = new Number( 0.25 );

		$number_3 = $calculator->add( $number_1, $number_2 );

		$this->assertSame( '100', $number_3->get_value() );
	}

	/**
	 * Test subtract.
	 */
	public function test_subtract() {
		$calculator = $this->get_calculator();

		$number_1 = new Number( 100 );

		$number_2 = new Number( 0.25 );

		$number_3 = $calculator->subtract( $number_1, $number_2 );

		$this->assertSame( '99.75', $number_3->get_value() );
	}

	/**
	 * Test multiply.
	 */
	public function test_multiply() {
		$calculator = $this->get_calculator();

		$number_1 = new Number( 100 );

		$number_2 = new Number( 0.25 );

		$number_3 = $calculator->multiply( $number_1, $number_2 );

		$this->assertSame( '25', $number_3->get_value() );
	}

	/**
	 * Test divide.
	 */
	public function test_divide() {
		$calculator = $this->get_calculator();

		$number_1 = new Number( 100 );

		$number_2 = new Number( 4 );

		$number_3 = $calculator->divide( $number_1, $number_2 );

		$this->assertSame( '25', $number_3->get_value() );
	}

	/**
	 * Test division by zero.
	 * 
	 * @link https://www.php.net/manual/en/class.divisionbyzeroerror.php
	 */
	public function test_division_by_zero() {
		$calculator = $this->get_calculator();

		$number = new Number( 100 );

		$zero = new Number( 0 );

		$this->expectException( \InvalidArgumentException::class );

		$result = $calculator->divide( $number, $zero );
	}

	/**
	 * Test absolute.
	 */
	public function test_absolute() {
		$calculator = $this->get_calculator();

		$number = new Number( -100 );

		$result = $calculator->absolute( $number );

		$this->assertSame( '100', $result->get_value() );
	}

	/**
	 * Test compare.
	 */
	public function test_compare() {
		$calculator = $this->get_calculator();

		$number_a = new Number( -100 );
		$number_b = new Number( '-100' );

		$result = $calculator->compare( $number_a, $number_b );

		$this->assertSame( 0, $result );

		$number_a = new Number( 1 );
		$number_b = new Number( 2 );

		$result = $calculator->compare( $number_a, $number_b );

		$this->assertSame( -1, $result );

		$number_a = new Number( 2 );
		$number_b = new Number( 1 );

		$result = $calculator->compare( $number_a, $number_b );

		$this->assertSame( 1, $result );
	}
}
