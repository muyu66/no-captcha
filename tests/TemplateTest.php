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
        $path = $this->getPrivate(Template::class, 'getViewPath', $code);
        $this->assertTrue($path && is_string($path), $path);
        return $path;
    }

    public function testCheckViewExist()
    {
        // 模拟访问正确的 View
        $path = $this->testGetViewPath();
        $result = $this->getPrivate(Template::class, 'checkViewExist', $path);
        $this->assertTrue(is_null($result));
        // 模拟访问不存在的 View
        $path = $this->testGetViewPath('code2');
        $func = function () use ($path) {
            return $this->getPrivate(Template::class, 'checkViewExist', $path);
        };
        $this->assertException($func);
    }

    public function testDataBind()
    {
        $result = $this->getPrivate(
            Template::class,
            'dataBind',
            [
                'a=v-url:generate,b=v-url:valid,c=v-url:query',
                [
                    'generate' => '1',
                    'valid' => '2',
                    'query' => '3',
                ]
            ]
        );
        $this->assertEquals('a=1,b=2,c=3', $result);
    }
}