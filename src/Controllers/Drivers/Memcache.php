<?php

namespace Muyu\Controllers\Drivers;

use Doctrine\Common\Cache\MemcachedCache;

class Memcache extends Driver
{
    protected $instance;

    protected static $key_separator = '/';

    protected static $key_catalog = 'muyu-no-captcha';

    public function setInstance($instance)
    {
        $this->instance = new MemcachedCache();
        $this->instance->setMemcached($instance);
    }
}
