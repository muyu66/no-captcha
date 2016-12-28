<?php

use Muyu\Controllers\SessionController;

class SessionTest extends PHPUnit_Framework_TestCase
{
    public function testGet()
    {
        $ctl = new SessionController();
        $this->assertEquals('', $ctl->get());
    }
}