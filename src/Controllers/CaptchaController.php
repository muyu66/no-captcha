<?php

namespace Muyu\Controllers;

class CaptchaController
{
    private $cache;

    public function __construct(CacheController $cache)
    {
        $this->cache = $cache;
    }

    public function generate()
    {
        $session = new SessionController();
        $rand = rand(1, 5);
        $this->cache->set($session->get(), time() + $rand, 30);
        return $rand;
    }

    public function valid()
    {
        $session = new SessionController();
        $session_id = $session->get();

        $this->cache->incr('block-' . $session_id, 1);
        $retry_limit = $this->cache->get('block-' . $session_id);
        if ($retry_limit >= 2) {
            return 'forbid';
        }

        $now_time = time();
        $old_time = $this->cache->get($session_id) ? : $now_time + 1;
        if ($old_time <= $now_time) {
            $this->cache->del($session_id);
            $this->cache->del('block-' . $session_id);
            $this->cache->set('token-' . $session_id, '', 30);
            return 'yes';
        } else {
            if ($this->cache->has('block-' . $session_id)) {
                $this->cache->incr('block-' . $session_id, 30);
            } else {
                $this->cache->set('block-' . $session_id, '0', 30);
            }
            return 'no';
        }
    }

    public function query()
    {
        $session = new SessionController();
        $session_id = $session->get();

        $is_allow = $this->cache->has('token-' . $session_id);
        if (!$is_allow) {
            return 'error';
        }
        $this->cache->del('token-' . $session_id);
    }
}
