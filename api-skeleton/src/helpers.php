<?php

if (!function_exists('lazy_get')) {
    /**
     * Gets the item which might be encapsulated in a callable for lazy evaluation.
     *
     * @param mixed $object
     * @param mixed ...$params
     * @return object
     */
    function lazy_get($object, ...$params): object
    {
        return is_callable($object) ? $object(...$params) : $object;
    }
}
