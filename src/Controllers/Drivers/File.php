<?php

namespace Muyu\Controllers\Drivers;

use Doctrine\Common\Cache\FilesystemCache;

class File extends Driver
{
    protected $instance;

    protected static $key_separator = '/';

    protected static $key_catalog = 'muyu-no-captcha';

    public function setInstance($instance)
    {
        $file = new FilesystemCache($instance);
        $this->instance = $file;
    }
}
