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
	 */
	public function test_add() {
		$number_1 = new Number( 99.75 );

		$number_2 = new Number( 0.25 );

		$number_3 = $number_1->add( $number_2 );

		$this->assertSame( '100', $number_3->get_value() );
	}

	/**
	 * Test subtract.
	 */
	public function test_subtract() {
		$number_1 = new Number( 100 );

		$number_2 = new Number( 0.25 );

		$number_3 = $number_1->subtract( $number_2 );

		$this->assertSame( '99.75', $number_3->get_value() );
	}

	/**
	 * Test multiply.
	 */
	public function test_multiply() {
		$number_1 = new Number( 100 );

		$number_2 = new Number( 5 );

		$number_3 = $number_1->multiply( $number_2 );

		$this->assertSame( '500', $number_3->get_value() );
	}

	/**
	 * Test divide.
	 */
	public function test_divide() {
		$number_1 = new Number( 100 );

		$number_2 = new Number( 5 );

		$number_3 = $number_1->divide( $number_2 );

		$this->assertSame( '20', $number_3->get_value() );
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
	 * Test from int.
	 *
	 * @link https://github.com/moneyphp/money/blob/v4.0.0/tests/NumberTest.php#L79-L86
	 */
	public function test_from_int() {
		$number = Number::from_int( 123 );

		$this->assertSame( '123', $number->get_value() );
	}

	/**
	 * Test from int exception.
	 */
	public function test_from_int_exception() {
		$this->expectException( \InvalidArgumentException::class );

		$number = Number::from_int( '123' );
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
	 * @param float  $value    Float value.
	 * @param string $expected Expected value.
	 * @dataProvider data_provider_from_float
	 */
	public function test_from_float( $value, $expected ) {
		$number = Number::from_float( $value );

		$this->assertSame( $expected, $number->get_value() );
	}

	/**
	 * Data provider from float test.
	 *
	 * @return array
	 */
	public function data_provider_from_float() {
		return array(
			array( 0.0, '0' ),
			array( 0.12345678, '0.12345678' ),
			array( 123.456789, '123.456789' ),
			array( 0.123456789, '0.123456789' ),
			array( 0.123456789123456789, \version_compare( \PHP_VERSION, '7.1', '<' ) ? '0.12345678912346' : '0.12345678912345678' ),
			array( 123456.789, '123456.789' ),
			array( 123456.78, '123456.78' ),
			array( 12345678901.123456789123456789, \version_compare( \PHP_VERSION, '7.1', '<' ) ? '12345678901.123' : '12345678901.123457' ),
		);
	}

	/**
	 * Test from float exception.
	 */
	public function test_from_float_exception() {
		$this->expectException( \InvalidArgumentException::class );

		$number = Number::from_float( '123' );
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
	 * @param mixed  $value    Value.
	 * @param string $expected Expected value.
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
		$data = array(
			array( '42', '42' ),
			array( 1337, '1337' ),
			array( 0x539, '1337' ), // Hexadecimal number.
			array( 02471, '1337' ), // Octal number.
			array( 0b10100111001, '1337' ), // Binary number.
			array( 1337e0, '1337' ),
			array( '02471', '02471' ),
			array( '1337e0', '1337e0' ),
			array( 9.1, '9.1' ),
		);

		/**
		 * On PHP version before 7 it seems that '0x539' is
		 * numeric.
		 */
		if ( version_compare( \PHP_VERSION, '7', '<' ) ) {
			$data[] = array( '0x539' );
		}

		return $data;
	}

	/**
	 * Test PHP.net `is_numeric()` examples.
	 *
	 * @link https://www.php.net/manual/en/function.is-numeric.php#refsect1-function.is-numeric-examples
	 * @dataProvider provider_php_not_numeric_examples
	 * @param mixed $value Value.
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
		$data = array(
			array( '0b10100111001' ),
			array( 'not numeric' ),
			array( array() ),
			array( null ),
			array( '' ),
			array( '-' ),
		);

		/**
		 * On PHP version after 5.6 it seems that '0x539' is
		 * not numeric.
		 */
		if ( version_compare( \PHP_VERSION, '7', '>=' ) ) {
			$data[] = array( '0x539' );
		}

		return $data;
	}

	/**
	 * Test PHP.net `abs()` examples.
	 *
	 * @link https://www.php.net/manual/en/function.abs.php
	 * @dataProvider provider_php_abs_examples
	 * @param mixed  $value    Value.
	 * @param string $expected Expected value.
	 */
	public function test_php_abs_examples( $value, $expected ) {
		$number = Number::from_mixed( $value );

		$absolute = $number->absolute();

		$this->assertSame( $expected, $absolute->get_value() );
	}

	/**
	 * Provider valid numeric examples.
	 *
	 * @link https://www.php.net/manual/en/language.types.integer.php
	 * @return array
	 */
	public function provider_php_abs_examples() {
		return array(
			array( -4.2, '4.2' ),
			array( 5, '5' ),
			array( -5, '5' ),
		);
	}

	/**
	 * Test format.
	 */
	public function test_format() {
		$number = Number::from_string( '1000000000.00' );

		$this->assertSame( '1.000.000.000,00', $number->format( 2, ',', '.' ) );
	}

	/**
	 * Test JSON.
	 */
	public function test_json() {
		$number = Number::from_string( '123456.789' );

		$expected = '"123456.789"';

		$this->assertJsonStringEqualsJsonString( $expected, \wp_json_encode( $number ) );
	}

	/**
	 * Test is zero.
	 */
	public function test_is_zero() {
		$number = Number::from_float( 0.00 );

		$this->assertTrue( $number->is_zero() );
	}

	/**
	 * Test to string.
	 */
	public function test_to_string() {
		$number = Number::from_float( 123456.78 );

		$this->assertSame( '123456.78', \strval( $number ) );
	}

	/**
	 * Test calculator exception.
	 */
	public function test_calculator() {
		$reflection = new \ReflectionClass( Number::class );

		$calculator_property = $reflection->getProperty( 'calculator' );
		$calculator_property->setAccessible( true );

		$calculator = $calculator_property->getValue();

		$calculator_property->setValue( null );

		$calculators_property = $reflection->getProperty( 'calculators' );
		$calculators_property->setAccessible( true );

		$calculators = $calculators_property->getValue();

		$calculators_property->setValue( array() );

		$number_1 = new Number( '1' );
		$number_2 = new Number( '2' );

		$this->expectException( \RuntimeException::class );

		$number_3 = $number_1->add( $number_2 );

		$calculator_property->setValue( $calculator );
		$calculators_property->setValue( $calculators );
	}


	/**
	 * Test format i18n.
	 *
	 * @link https://github.com/WordPress/WordPress/blob/4.9.5/wp-includes/l10n.php
	 *
	 * @param string $locale   Locale.
	 * @param int    $decimals Decimals.
	 * @param float  $value    Money value.
	 * @param string $expected Expected format.
	 *
	 * @dataProvider format_i18n_provider
	 */
	public function test_format_i18n( $locale, $decimals, $value, $expected ) {
		\switch_to_locale( $locale );

		$number = new Number( $value );

		$string = $number->format_i18n( $decimals );

		$this->assertEquals( $locale, \get_locale() );
		$this->assertSame( $expected, $string );
	}

	/**
	 * Format i18n provider.
	 *
	 * @return array
	 */
	public function format_i18n_provider() {
		return array(
			// Dutch.
			array( 'nl_NL', 2, 49.7512, '49,75' ),
			array( 'nl_NL', 4, 49.7512, '49,7512' ),
			array( 'nl_NL', 2, 1234567890.1234, '1.234.567.890,12' ),

			// English.
			array( 'en_US', 2, 49.7512, '49.75' ),
			array( 'en_US', 2, 1234567890.1234, '1,234,567,890.12' ),

			// French.
			array( 'fr_FR', 2, 1234567890.1234, '1 234 567 890,12' ),
		);
	}
}
