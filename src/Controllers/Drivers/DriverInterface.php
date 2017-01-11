<?php

namespace Muyu\Controllers\Drivers;

interface DriverInterface
{
    public function getInstance();

    public function setInstance($instance);

    public function setStyle($key_catalog, $key_separator);

    public function set($key, $context, $second);

    public function get($key);

    public function del($key);

    public function has($key);

    public function incr($key, $second);

    public function delAll();

    public function getKey($key);
}