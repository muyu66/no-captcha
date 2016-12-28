<?php

use Muyu\Controllers\CacheController;

class CacheTest extends PHPUnit_Framework_TestCase
{
    public function testDelAll()
    {
        $ctl = new CacheController();
        $ctl->delAll();
        $result = $ctl->get('unit');
        $this->assertEquals(null, $result);
    }

    public function testSet()
    {
        $ctl = new CacheController();
        $result = $ctl->set('unit', 'unit111', 2);
        $this->assertEquals(true, $result);
    }

    public function testGet()
    {
        $ctl = new CacheController();
        $result = $ctl->get('unit');
        $this->assertEquals('unit111', $result);
    }

    public function testDel()
    {
        $ctl = new CacheController();
        $this->testSet();
        $result = $ctl->del('unit');
        $this->assertEquals(true, $result);
    }

    public function testHas()
    {
        $ctl = new CacheController();
        $this->testSet();
        $result = $ctl->has('unit');
        $this->assertEquals(true, $result);
        $this->testDel();
        $result = $ctl->has('unit');
        $this->assertEquals(false, $result);
    }

    public function testIncr()
    {
        $ctl = new CacheController();
        $result = $ctl->incr('unit', 1);
        $this->assertEquals(null, $result);
        $ctl->set('unit', '0', 2);
        $result = $ctl->incr('unit', 1);
        $this->assertEquals(1, $result);
    }

    public function testSetStyle()
    {
        $ctl = new CacheController();
        $this->assertEquals('muyu-no-captcha/unit', $ctl->getKey('unit'));
        $ctl->setStyle('google', '-');
        $this->assertEquals('google-unit', $ctl->getKey('unit'));
    }
}