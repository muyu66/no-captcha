<?php

namespace TestCase;

use ReflectionMethod;
use PHPUnit_Framework_TestCase;
use Exception;

class TestCase extends PHPUnit_Framework_TestCase
{
    public function getPrivate($class, $func, $params = null)
    {
        if (is_string($params)) {
            $params = [$params];
        }
        $ctl = new ReflectionMethod($class, $func);
        $ctl->setAccessible(true);
        return $ctl->invokeArgs(new $class(), $params);
    }

    public function assertException($func)
    {
        try {
            $func();
            $result = false;
        } catch (Exception $e) {
            $result = true;
        }
        $this->assertTrue($result);
    }
}
