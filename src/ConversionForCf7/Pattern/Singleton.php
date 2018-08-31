<?php

namespace ConversionForCf7\Pattern;

/**
 * Singleton pattern
 *
 * @package ConversionForCf7\Pattern
 */
class Singleton {

    private static $instances = [];

    /**
     * Singleton constructor.
     */
    final protected function __construct() {
        $this->on_construct();
    }

    /**
     * Executed in constructor.
     */
    protected function on_construct() {
    }

    /**
     * Get instance
     *
     * @return static
     */
    public static function get_instance() {
        $class_name = get_called_class();
        if ( ! isset( self::$instances[ $class_name ] ) ) {
            self::$instances[ $class_name ] = new $class_name();
        }

        return self::$instances[ $class_name ];
    }
}
