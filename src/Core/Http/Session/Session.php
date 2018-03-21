<?php

namespace Core\Http\Session;

/**
 * Class for works with session as object
 *
 * @package Core\Http\Session
 */
class Session
{
    private static $instance;

    private static $isInit = false;

    private function __construct()
    {
        session_start();
    }

    public static function getInstance()
    {
        if (!self::$isInit) {
            self::$instance = new self();
            self::$isInit = true;
        }

        return self::$instance;
    }

    public function has($name)
    {
        return isset($_SESSION[$name]);
    }

    public function get($name)
    {
        return $_SESSION[$name] ?? null;
    }

    public function set($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    public function remove($name)
    {
        unset($_SESSION[$name]);
    }
}
