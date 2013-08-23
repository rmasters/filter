<?php

namespace Filter;

class Address extends \Illuminate\Database\Eloquent\Model
{
    use HasFilters;

	protected $input = array(
		'line1' => 'trim',
		'city' => 'trim',
		'postcode' => 'upper|trim',
		'country' => 'trim',
	);

	protected $output = array(
		'city' => 'upper',
		'country' => 'upper',
	);

	/**
	 * Mutator for Country - should have passed through setAttribute first
	 * 
	 * @param string $value The filtered input value
	 */
	public function setCountryAttribute($value) {
		$this->attributes['country'] = $value . '_input';
	}

	/**
	 * Accessor for Country - result should be passed through getAttribute
	 *
	 * @param string The unfiltered output value
	 */
	public function getCountryAttribute($value) {
		return $value . '_output';
	}
}

class HasFiltersTest extends \PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->address = new Address;
	}

	public function testInputs()
	{
		$this->address->line1 = '123 Bank Rd ';
		$this->address->city = ' London ';
		$this->address->postcode = 'sw1 1aa ';
		$this->address->country = '  england  ';

		// Get attrs without using the overridden getAttribute()
		$raw = $this->address->getAttributes();
		$this->assertEquals('123 Bank Rd', $raw['line1']);
		$this->assertEquals('London', $raw['city']);
		$this->assertEquals('SW1 1AA', $raw['postcode']);
		$this->assertEquals('england_input', $raw['country']);
	}

	public function testOutputs()
	{
		$this->address->setRawAttributes(array(
			'city' => 'London',
			'country' => 'england',
		));

		$this->assertEquals('LONDON', $this->address->city);
		$this->assertEquals('ENGLAND_OUTPUT', $this->address->country);
	}
}