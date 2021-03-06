<?php

namespace TestCase;

use Muyu\Controllers\Template;

class TemplateTest extends TestCase
{
    public function testView()
    {
        $ctl = new Template();
        $this->assertContains('function', $ctl->view('code'));
    }

    public function testGetViewPath($code = 'code')
    {
        $ctl = new Template();
        $paths = $ctl->getViewPath($code);
        $this->assertTrue($paths && is_array($paths), $paths);
        return $paths;
    }

    public function testCheckViewExist()
    {
        // 模拟访问正确的 View
        $path = $this->testGetViewPath();
        $ctl = new Template();
        $result = $ctl->checkViewExist($path);
        $this->assertTrue(is_string($result));

        // 模拟访问不存在的 View
        $path = $this->testGetViewPath('code2');
        $func = function () use ($path) {
            $ctl = new Template();
            return $ctl->checkViewExist($path);
        };
        $this->assertException($func);
    }

    public function testDataBind()
    {
        $ctl = new Template();
        $result = $ctl->dataBind(
            'd=v-bind:name,e=v-bind:sign,f=v-bind:message',
            [
                'name' => '4',
                'sign' => '5',
                'message' => '6',
            ]
        );
        $this->assertEquals('d=4,e=5,f=6', $result);
    }
}
