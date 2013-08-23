<?php

namespace Filter\Facades;

use Illuminate\Support\Facades\Facade;
use Filter\FilterServiceProvider;

/**
 * Laravel 4 facade for the Filter instance
 */
class Filter extends Facade
{
    /**
     * Get the registered component.
     *
     * @return object
     */
    protected static function getFacadeAccessor()
	{
		// If the app does not exist, get one with FilterServiceProvider booted
        if (!static::$app) {
            static::$app = FilterServiceProvider::make();
        }

        return 'filter';
    }
}