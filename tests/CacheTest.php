<?php

use PHPUnit\Framework\TestCase;
use Muyu\Controllers\CacheController;

class CacheTest extends TestCase
{
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
}