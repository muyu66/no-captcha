<?php

use Muyu\Controllers\CaptchaController;
use Muyu\Controllers\CacheController;

class CaptchaTest extends PHPUnit_Framework_TestCase
{
    public function testGenerate()
    {
        $cache = new CacheController();
        $cache->delAll();
        $ctl = new CaptchaController($cache);
        $result = $ctl->generate();
        $this->assertTrue(is_numeric($result));
    }

    public function testValid()
    {
        $cache = new CacheController();
        $ctl = new CaptchaController($cache);
        // 模拟机器快速验证
        $result = $ctl->valid();
        $this->assertEquals('no', $result);
        // 模拟机器连续验证
        foreach (range(1, 3) as $i) {
            $ctl->valid();
        }
        $result = $ctl->valid();
        $this->assertEquals('forbid', $result);
        // 模拟机器等待后验证
        sleep(6);
        $result = $ctl->valid();
        $this->assertEquals('yes', $result);
    }

    public function testQuery()
    {
        $cache = new CacheController();
        $ctl = new CaptchaController($cache);
        // 模拟成功验证
        $result = $ctl->query();
        $this->assertEquals(null, $result);
        // 模拟失败验证
        $result = $ctl->query();
        $this->assertEquals('error', $result);
    }
}