<?php

namespace Muyu\Controllers;

class Session
{
    public function get()
    {
        return session_id();
    }
}
