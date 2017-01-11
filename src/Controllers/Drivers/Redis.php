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
        $config = require('./config.php');
        $host = $config['connections']['redis']['host'];
        $port = $config['connections']['redis']['port'];
        $database = $config['connections']['redis']['database'];
        $password = $config['connections']['redis']['password'];

        $redis = new Client(compact('host', 'port', 'database', 'password'));

        $this->instance = new PredisCache($redis);
    }
}
