<?php

namespace Muyu\Controllers;

use Muyu\Controllers\Drivers\Driver;
use Muyu\Controllers\Drivers\File;
use Muyu\Controllers\Drivers\Memcache;
use Muyu\Controllers\Drivers\Redis;

class Captcha
{
    /**
     * @var Driver
     */
    private $driver;

    public function useMemcache($memcache)
    {
        $this->driver = new Memcache($memcache);
    }

    public function useFile($file)
    {
        $this->driver = new File($file);
    }

    public function useRedis($redis)
    {
        $this->driver = new Redis($redis);
    }

    public function view($params)
    {
        $ctl = new Template();
        return $ctl->view('code', $params);
    }

    public function generate()
    {
        $session = new Session();
        $rand = rand(1, 5);
        $this->driver->set($session->get(), time() + $rand, 30);
        return $rand;
    }

    public function valid()
    {
        $session = new Session();
        $session_id = $session->get();

        $this->driver->incr('block-' . $session_id, 1);
        $retry_limit = $this->driver->get('block-' . $session_id);
        if ($retry_limit >= 2) {
            return 'forbid';
        }

        $now_time = time();
        $old_time = $this->driver->get($session_id) ? : $now_time + 1;
        if ($old_time <= $now_time) {
            $this->driver->del($session_id);
            $this->driver->del('block-' . $session_id);
            $this->driver->set('token-' . $session_id, '', 30);
            return 1;
        } else {
            if ($this->driver->has('block-' . $session_id)) {
                $this->driver->incr('block-' . $session_id, 30);
            } else {
                $this->driver->set('block-' . $session_id, '0', 30);
            }
            return 0;
        }
    }

    public function query()
    {
        $session = new Session();
        $session_id = $session->get();

        $is_allow = $this->driver->has('token-' . $session_id);
        if (! $is_allow) {
            return 0;
        }
        $this->driver->del('token-' . $session_id);
        return 1;
    }
}
