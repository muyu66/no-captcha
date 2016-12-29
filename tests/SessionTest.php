<?php

namespace TestCase;

use Muyu\Controllers\SessionController;

class SessionTest extends TestCase
{
    public function testGet()
    {
        $ctl = new SessionController();
        $this->assertEquals('', $ctl->get());
    }
}