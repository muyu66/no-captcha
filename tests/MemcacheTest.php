<?php

namespace TestCase;

use Doctrine\Common\Cache\MemcachedCache;
use Muyu\Controllers\Drivers\Memcache;
use Memcached;

class MemcacheTest extends TestCase
{
    private $memcache;

    public function setUp()
    {
        parent::setUp();
        $config = require('./config.php');
        $host = $config['connections']['memcache']['host'];
        $port = $config['connections']['memcache']['port'];

        $memcached = new Memcached();
        $memcached->setOption(Memcached::OPT_COMPRESSION, false);
        $memcached->addServer($host, $port);
        $this->memcache = $memcached;
    }

    public function testGetInstance()
    {
        $ctl = new Memcache($this->memcache);
        $instance = $ctl->getInstance();
        $this->assertInstanceOf(MemcachedCache::class, $instance);
    }

    public function testDelAll()
    {
        $ctl = new Memcache($this->memcache);
        $ctl->delAll();
        $result = $ctl->get('unit');
        $this->assertEquals(null, $result);
    }

    public function testSet()
    {
        $ctl = new Memcache($this->memcache);
        $result = $ctl->set('unit', 'unit111', 2);
        $this->assertEquals(true, $result);
    }

    public function testGet()
    {
        $ctl = new Memcache($this->memcache);
        $result = $ctl->get('unit');
        $this->assertEquals('unit111', $result);
    }

    public function testDel()
    {
        $ctl = new Memcache($this->memcache);
        $this->testSet();
        $result = $ctl->del('unit');
        $this->assertEquals(true, $result);
    }

    public function testHas()
    {
        $ctl = new Memcache($this->memcache);
        $this->testSet();
        $result = $ctl->has('unit');
        $this->assertEquals(true, $result);
        $this->testDel();
        $result = $ctl->has('unit');
        $this->assertEquals(false, $result);
    }

    public function testIncr()
    {
        $ctl = new Memcache($this->memcache);
        $result = $ctl->incr('unit', 1);
        $this->assertEquals(null, $result);
        $ctl->set('unit', '0', 2);
        $result = $ctl->incr('unit', 1);
        $this->assertEquals(1, $result);
    }

    public function testSetStyle()
    {
        $ctl = new Memcache($this->memcache);
        $this->assertEquals('muyu-no-captcha/unit', $ctl->getKey('unit'));
        $ctl->setStyle('google', '-');
        $this->assertEquals('google-unit', $ctl->getKey('unit'));
    }
}