<?php

namespace Filter;

use Mockery as m;

class FilterServiceProviderTest extends \PHPUnit_Framework_TestCase
{
	private $app;
	private $provider;

	public function setUp()
	{
		$this->app = m::mock('Illuminate\Support\Container');
		$this->provider = new FilterServiceProvider($this->app);
	}

	public function testRegister()
	{
		$this->provider->register();
	}

	public function testBoot()
	{
		// Make sure that boot() registers the singleton instance
		$this->app
			->shouldReceive('singleton')
			->with('filter', m::on(function($closure) {
				// The closure should create an instance of Filter\Filter
				return call_user_func($closure, null) instanceof Filter;
			}))
			->times(1);

		$this->provider->boot();
	}

	public function testProvides()
	{
		$this->assertContains('filter', $this->provider->provides());
	}
}