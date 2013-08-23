<?php

namespace Filter;

use \Illuminate\Support\ServiceProvider;

/**
 * Laravel 4 service for Filter
 */
class FilterServiceProvider extends ServiceProvider
{
	/**
	 * Register the service
	 */
	public function register()
	{
    }

	/**
	 * Boot the service
	 * Registers a singleton Filter instance
	 */
	public function boot()
	{
        $this->app->singleton('filter', function ($app) {
            $filter = new Filter();
            $filter->registerDefaultFilters();
            return $filter;
        });
    }

	/**
	 * Instances provided by the service
	 */
	public function provides()
	{
        return array('filter');
	}

	/**
	 * Build a new Laravel 4 container, add and boot the service to it
	 * Used when a Laravel 4 application does not exist from the Facade
	 *
	 * @return \Illuminate\Container\Container
	 */
	public static function make()
	{
		$app = new \Illuminate\Container\Container;
		$service = new self($app);
		$service->boot();

		return $app;
	}
}