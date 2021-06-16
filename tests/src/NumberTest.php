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

		$this->assertSame( '100', $number_3->get_value() );
	}

	/**
	 * Test trim trailing zeros.
	 * 
	 * @link https://www.php.net/manual/en/function.bcscale.php#107259
	 */
	public function test_trim_trailing_zeros() {
		$number = Number::from_string( '100.0000' );

		$this->assertSame( '100.0000', $number->get_value() );

		$one = Number::from_string( '1' );

		$result = $number->add( $one );

		$this->assertSame( '101', $result->get_value() );
	}

	/**
	 * Test leading zeros.
	 */
	public function test_leading_zeros() {
		$number = Number::from_string( '000.000123' );

		$this->assertSame( '000.000123', $number->get_value() );

		$number = Number::from_float( 000.000123 );

		$this->assertSame( '0.000123', $number->get_value() );
	}

	/**
	 * Test PHP integer max.
	 * 
	 * @link https://www.php.net/manual/en/reserved.constants.php
	 */
	public function test_int_max() {
		$int_max_32_bit = 2147483647;

		$number = Number::from_int( $int_max_32_bit );

		$this->assertSame( '2147483647', $number->get_value() );
	}

	/**
	 * Test PHP integer min.
	 * 
	 * @link https://www.php.net/manual/en/reserved.constants.php
	 */
	public function test_int_min() {
		$int_min_32_bit = -2147483648;

		$number = Number::from_int( $int_min_32_bit );

		$this->assertSame( '-2147483648', $number->get_value() );
	}

	/**
	 * Test floating point math.
	 * 
	 * @link https://0.30000000000000004.com/#php
	 */
	public function test_0_dot_3() {
		$number_0_dot_1 = Number::from_float( 0.1 );
		$number_0_dot_2 = Number::from_float( 0.2 );

		$result = $number_0_dot_1->add( $number_0_dot_2 );

		$this->assertSame( '0.3', $result->get_value() );
	}

	/**
	 * Test from float.
	 * 
	 * @link https://github.com/moneyphp/money/blob/v4.0.0/tests/NumberTest.php#L79-L86
	 */
	public function test_from_float() {
		$var_1 = Number::from_string( '123.456789' );
		$var_2 = Number::from_float( 123.456789 );

		$this->assertSame( $var_1->get_value(), $var_2->get_value() );
	}

	/**
	 * Test max + max 32 bit.
	 * 
	 * @link https://github.com/moneyphp/money/blob/v4.0.0/tests/NumberTest.php#L79-L86
	 */
	public function test_max_add_32_bit() {
		$var_1 = Number::from_string( '2147483647' );
		$var_2 = Number::from_string( '2147483647' );

		$sum = $var_1->add( $var_2 );

		$this->assertSame( '4294967294', $sum->get_value() );
	}

	/**
	 * Test max + max 64 bit.
	 * 
	 * @link https://github.com/moneyphp/money/blob/v4.0.0/tests/NumberTest.php#L79-L86
	 */
	public function test_max_add_64_bit() {
		$var_1 = Number::from_string( '9223372036854775807' );
		$var_2 = Number::from_string( '9223372036854775807' );

		$sum = $var_1->add( $var_2 );

		$this->assertSame( '18446744073709551614', $sum->get_value() );
	}

	/**
	 * Test exponential form e0.
	 * 
	 * @link https://stackoverflow.com/questions/6607819/php-floating-point-number-shown-in-exponential-form
	 */
	public function test_exponential_form_0() {
		$number = Number::from_string( '1337e0' );

		$this->assertSame( '1337e0', $number->get_value() );
	}

	/**
	 * Test exponential form e18.
	 * 
	 * @link https://stackoverflow.com/questions/6607819/php-floating-point-number-shown-in-exponential-form
	 */
	public function test_exponential_form_18() {
		$number = Number::from_string( '9.223372036854776e18' );

		$this->assertSame( '9.223372036854776e18', $number->get_value() );
	}

	/**
	 * Test PHP.net `is_numeric()` examples.
	 * 
	 * @link https://www.php.net/manual/en/function.is-numeric.php#refsect1-function.is-numeric-examples
	 * @dataProvider provider_php_is_numeric_examples
	 */
	public function test_php_is_numeric_examples( $value, $expected ) {
		$number = Number::from_mixed( $value );

		$this->assertSame( $expected, $number->get_value() );
	}

	/**
	 * Provider valid numeric examples.
	 * 
	 * @link https://www.php.net/manual/en/language.types.integer.php
	 * @return array
	 */
	public function provider_php_is_numeric_examples() {
		return array(
			array( "42", '42' ),
			array( 1337, '1337' ),
			array( 0x539, '1337' ), // hexadecimal number
			array( 02471, '1337' ), // octal number
			array( 0b10100111001, '1337' ), // binary number
			array( 1337e0, '1337' ),
			array( "02471", '02471' ),
			array( "1337e0", '1337e0' ),
			array( 9.1, '9.1' ),
		);
	}

	/**
	 * Test PHP.net `is_numeric()` examples.
	 * 
	 * @link https://www.php.net/manual/en/function.is-numeric.php#refsect1-function.is-numeric-examples
	 * @dataProvider provider_php_not_numeric_examples
	 */
	public function test_php_not_numeric_examples( $value ) {
		$this->expectException( \InvalidArgumentException::class );

		$number = Number::from_mixed( $value );
	}

	/**
	 * Provider not numeric examples.
	 * 
	 * @return array
	 */
	public function provider_php_not_numeric_examples() {
		return array(
			array( "0x539" ),
			array( "0b10100111001" ),
			array( "not numeric" ),
			array( array() ),
			array( null ),
			array( '' ),
			array( '-' ),
		);
	}
}
