<?php

namespace Filter;

use Filter\Facades\Filter;

/**
 * Modifies accessors and mutators of an eloquent model to implement input and
 * output filters.
 *
 * Looks for two properties on the model:
 * $input and $output: an array of field names to filter rules (string or array)
 * $output is used for accessors (getAttribute, __get) and $input for mutators
 * (setAttribute, __set).
 */
trait HasFilters
{
	/**
	 * Override accessors to apply output filters
	 *
	 * @param string $key
	 * @return mixed
	 */
    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);

        if (isset($this->output) && array_key_exists($key, $this->output)) {
            $value = Filter::filterOne($this->output[$key], $value);
        }

        return $value;
    }

	/**
	 * Override mutators to add input filters
	 *
	 * @param string $key
	 * @param mixed $value
	 */
    public function setAttribute($key, $value)
    {
        if (isset($this->input) && array_key_exists($key, $this->input)) {
            $value = Filter::filterOne($this->input[$key], $value);
        }
        
        parent::setAttribute($key, $value);
    }
}