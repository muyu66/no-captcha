<?php

namespace Muyu\Controllers;

class SessionController
{
    public function get()
    {
        return session_id();
    }
}
