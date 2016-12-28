<?php

namespace Muyu\Controllers;

use Doctrine\Common\Cache\FilesystemCache;

class CacheController
{
    private $instance;

    public function __construct()
    {
        if ($this->instance) {
            return $this->instance;
        } else {
            $this->instance = new FilesystemCache('./tmp/cache/');
        }
    }

    public function set($key, $context, $time)
    {
        return $this->instance->save($key, $context, $time);
    }

    public function get($key)
    {
        return $this->instance->fetch($key);
    }
}
