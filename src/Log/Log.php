<?php namespace MoodleSDK\Log;

define('EOL', "\n");

abstract class Log
{

    private static $instance;

    public $lines = [];

    protected function __construct()
    {
        register_shutdown_function(function () {
            self::getInstance()->render();
        });
    }

    public static function getInstance()
    {
        if (self::$instance) {
            return self::$instance;
        }
        $c = get_called_class();
        self::$instance = $c::newInstance();
        return self::$instance;
    }

    public static function i()
    {
        return self::getInstance();
    }

    abstract protected static function newInstance();

    abstract protected function render();
}
