<?php

namespace Muyu\Controllers\Drivers;

use Doctrine\Common\Cache\MemcachedCache;
use Memcached;

class Memcache
{
    private $instance;
    private static $key_separator = '/';
    private static $key_catalog = 'muyu-no-captcha';

    public function __construct()
    {
        if ($this->instance) {
            return $this->instance;
        }

        $memcached = new Memcached();
        $memcached->setOption(Memcached::OPT_COMPRESSION, false);
        $memcached->addServer('127.0.0.1', 11211);

        $this->instance = new MemcachedCache();
        $this->instance->setMemcached($memcached);
        return $this->instance;
    }

    public function setStyle($key_catalog, $key_separator)
    {
        self::$key_catalog = $key_catalog;
        self::$key_separator = $key_separator;
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
        return self::$key_catalog . self::$key_separator . $key;
    }
}
