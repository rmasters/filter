<?php

namespace Filter;

/**
 * Basically Invokable <https://wiki.php.net/rfc/invokable>
 */
interface FilterInterface
{
    public function __invoke($value);
}