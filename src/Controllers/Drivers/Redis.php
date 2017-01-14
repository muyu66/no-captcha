<?php

namespace Muyu\Controllers\Drivers;

use Doctrine\Common\Cache\PredisCache;
use Predis\Client;

class Redis extends Driver
{
    protected $instance;

    protected static $key_separator = '/';

    protected static $key_catalog = 'muyu-no-captcha';

    public function setInstance($instance)
    {
        $this->instance = new PredisCache($instance);
    }
}
