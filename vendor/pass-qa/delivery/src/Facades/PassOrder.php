<?php

namespace PassQa\Delivery\Facades;

use Illuminate\Support\Facades\Facade;

class PassOrder extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'pass-order';
    }
}