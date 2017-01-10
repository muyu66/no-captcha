<?php

namespace TestCase;

use Muyu\Controllers\Drivers\Memcache;

class MemcacheTest extends TestCase
{
    public function testDelAll()
    {
        $ctl = new Memcache();
        $ctl->delAll();
        $result = $ctl->get('unit');
        $this->assertEquals(null, $result);
    }

    public function testSet()
    {
        $ctl = new Memcache();
        $result = $ctl->set('unit', 'unit111', 2);
        $this->assertEquals(true, $result);
    }

    public function testGet()
    {
        $ctl = new Memcache();
        $result = $ctl->get('unit');
        $this->assertEquals('unit111', $result);
    }

    public function testDel()
    {
        $ctl = new Memcache();
        $this->testSet();
        $result = $ctl->del('unit');
        $this->assertEquals(true, $result);
    }

    public function testHas()
    {
        $ctl = new Memcache();
        $this->testSet();
        $result = $ctl->has('unit');
        $this->assertEquals(true, $result);
        $this->testDel();
        $result = $ctl->has('unit');
        $this->assertEquals(false, $result);
    }

    public function testIncr()
    {
        $ctl = new Memcache();
        $result = $ctl->incr('unit', 1);
        $this->assertEquals(null, $result);
        $ctl->set('unit', '0', 2);
        $result = $ctl->incr('unit', 1);
        $this->assertEquals(1, $result);
    }

    public function testSetStyle()
    {
        $ctl = new Memcache();
        $this->assertEquals('muyu-no-captcha/unit', $ctl->getKey('unit'));
        $ctl->setStyle('google', '-');
        $this->assertEquals('google-unit', $ctl->getKey('unit'));
    }
}