<?php

namespace Luinuxscl\PostPilot\Facades;

use Illuminate\Support\Facades\Facade;

class PostPilot extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'postpilot';
    }
}
