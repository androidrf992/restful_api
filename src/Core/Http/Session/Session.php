<?php

namespace Core\Http\Session;

class Session
{
    private $params;

    private static $instance;

    private static $isInit = false;

    private function __construct()
    {
        session_start();
        $this->params = $_SESSION;
    }

    public static function getInstance()
    {
        if (!self::$isInit) {
            self::$instance = new self();
            self::$isInit = true;
        }

        return self::$instance;
    }
}