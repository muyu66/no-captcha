<?php

namespace TestCase;

use Muyu\Controllers\Session;

class SessionTest extends TestCase
{
    public function testGet()
    {
        $ctl = new Session();
        $this->assertEquals('', $ctl->get());
    }
}