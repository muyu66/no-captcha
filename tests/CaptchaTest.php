<?php

namespace TestCase;

use Muyu\Controllers\Captcha;
use Memcached;

class CaptchaTest extends TestCase
{
    private $memcached;

    public function setUp()
    {
        parent::setUp();
        $config = require('./config.php');
        $host = $config['connections']['memcache']['host'];
        $port = $config['connections']['memcache']['port'];

        $memcached = new Memcached();
        $memcached->setOption(Memcached::OPT_COMPRESSION, false);
        $memcached->addServer($host, $port);
        $this->memcached = $memcached;
    }

    public function testGenerate()
    {
        $ctl = new Captcha();
        $ctl->useMemcache($this->memcached);
        $result = $ctl->generate();
        $this->assertTrue(is_numeric($result));
    }

    public function testValid()
    {
        $ctl = new Captcha();
        $ctl->useMemcache($this->memcached);

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
        $ctl = new Captcha();
        $ctl->useMemcache($this->memcached);

        // 模拟成功验证
        $result = $ctl->query();
        $this->assertEquals(null, $result);

        // 模拟失败验证
        $result = $ctl->query();
        $this->assertEquals('error', $result);
    }
}
