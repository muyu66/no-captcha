<?php

namespace TestCase;

use Doctrine\Common\Cache\FilesystemCache;
use Muyu\Controllers\Drivers\File;

class FileTest extends TestCase
{
    private $file;

    public function setUp()
    {
        parent::setUp();
        $config = require('./config.php');
        $file = $config['connections']['file']['path'];
        $this->file = $file;
    }

    public function testGetInstance()
    {
        $ctl = new File($this->file);
        $instance = $ctl->getInstance();
        $this->assertInstanceOf(FilesystemCache::class, $instance);
    }

    public function testDelAll()
    {
        $ctl = new File($this->file);
        $ctl->delAll();
        $result = $ctl->get('unit');
        $this->assertEquals(null, $result);
    }

    public function testSet()
    {
        $ctl = new File($this->file);
        $result = $ctl->set('unit', 'unit111', 2);
        $this->assertEquals(true, $result);
    }

    public function testGet()
    {
        $ctl = new File($this->file);
        $result = $ctl->get('unit');
        $this->assertEquals('unit111', $result);
    }

    public function testDel()
    {
        $ctl = new File($this->file);
        $this->testSet();
        $result = $ctl->del('unit');
        $this->assertEquals(true, $result);
    }

    public function testHas()
    {
        $ctl = new File($this->file);
        $this->testSet();
        $result = $ctl->has('unit');
        $this->assertEquals(true, $result);
        $this->testDel();
        $result = $ctl->has('unit');
        $this->assertEquals(false, $result);
    }

    public function testIncr()
    {
        $ctl = new File($this->file);
        $result = $ctl->incr('unit', 1);
        $this->assertEquals(null, $result);
        $ctl->set('unit', '0', 2);
        $result = $ctl->incr('unit', 1);
        $this->assertEquals(1, $result);
    }

    public function testSetStyle()
    {
        $ctl = new File($this->file);
        $this->assertEquals('muyu-no-captcha/unit', $ctl->getKey('unit'));
        $ctl->setStyle('google', '-');
        $this->assertEquals('google-unit', $ctl->getKey('unit'));
    }
}