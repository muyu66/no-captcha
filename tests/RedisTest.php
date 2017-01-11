<?php

namespace TestCase;

use Doctrine\Common\Cache\PredisCache;
use Muyu\Controllers\Drivers\Redis;
use Predis\Client;

class RedisTest extends TestCase
{
    private $redis;

    public function setUp()
    {
        parent::setUp();
        $config = require('./config.php');
        $host = $config['connections']['redis']['host'];
        $port = $config['connections']['redis']['port'];
        $database = $config['connections']['redis']['database'];
        $password = $config['connections']['redis']['password'];

        $redis = new Client(compact('host', 'port', 'database', 'password'));
        $this->redis = $redis;
    }

    public function testGetInstance()
    {
        $ctl = new Redis($this->redis);
        $instance = $ctl->getInstance();
        $this->assertInstanceOf(PredisCache::class, $instance);
    }

    public function testDelAll()
    {
        $ctl = new Redis($this->redis);
        $ctl->delAll();
        $result = $ctl->get('unit');
        $this->assertEquals(null, $result);
    }

    public function testSet()
    {
        $ctl = new Redis($this->redis);
        $result = $ctl->set('unit', 'unit111', 2);
        $this->assertEquals(true, $result);
    }

    public function testGet()
    {
        $ctl = new Redis($this->redis);
        $result = $ctl->get('unit');
        $this->assertEquals('unit111', $result);
    }

    public function testDel()
    {
        $ctl = new Redis($this->redis);
        $this->testSet();
        $result = $ctl->del('unit');
        $this->assertEquals(true, $result);
    }

    public function testHas()
    {
        $ctl = new Redis($this->redis);
        $this->testSet();
        $result = $ctl->has('unit');
        $this->assertEquals(true, $result);
        $this->testDel();
        $result = $ctl->has('unit');
        $this->assertEquals(false, $result);
    }

    public function testIncr()
    {
        $ctl = new Redis($this->redis);
        $result = $ctl->incr('unit', 1);
        $this->assertEquals(null, $result);
        $ctl->set('unit', '0', 2);
        $result = $ctl->incr('unit', 1);
        $this->assertEquals(1, $result);
    }

    public function testSetStyle()
    {
        $ctl = new Redis($this->redis);
        $this->assertEquals('muyu-no-captcha/unit', $ctl->getKey('unit'));
        $ctl->setStyle('google', '-');
        $this->assertEquals('google-unit', $ctl->getKey('unit'));
    }
}