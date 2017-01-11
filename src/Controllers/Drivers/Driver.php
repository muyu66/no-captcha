<?php

namespace Muyu\Controllers\Drivers;

class Driver implements DriverInterface
{
    /**
     * @var mixed
     */
    protected $instance;

    protected static $key_separator = '/';

    protected static $key_catalog = 'muyu-no-captcha';

    public function __construct($instance)
    {
        $this->setInstance($instance);
    }

    public function getInstance()
    {
        return $this->instance;
    }

    public function setInstance($instance)
    {

    }

    public function setStyle($key_catalog, $key_separator)
    {
        static::$key_catalog = $key_catalog;
        static::$key_separator = $key_separator;
    }

    public function set($key, $context, $second)
    {
        return $this->instance->save($this->getKey($key), $context, $second);
    }

    public function get($key)
    {
        return $this->instance->fetch($this->getKey($key));
    }

    public function del($key)
    {
        return $this->instance->delete($this->getKey($key));
    }

    public function has($key)
    {
        return $this->get($key) !== false;
    }

    public function incr($key, $second)
    {
        $exist = $this->get($key);
        if (is_numeric($exist)) {
            $this->set($key, $exist + 1, $second);
            return $exist + 1;
        }
        return null;
    }

    public function delAll()
    {
        return $this->instance->deleteAll();
    }

    public function getKey($key)
    {
        return static::$key_catalog . static::$key_separator . $key;
    }
}
