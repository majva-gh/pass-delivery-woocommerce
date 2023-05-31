<?php

namespace PassQa\Delivery\Library\Tests;

use Orchestra\Testbench\TestCase;
use PassQa\Delivery\Facades\PassOrder;
use PassQa\Delivery\Providers\PassDeliveryApiServiceProvider;

class PassTestCase extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            PassDeliveryApiServiceProvider::class
        ];
    }

    protected function getPackageAliases($app)
    {
        return[
            "PassOrder" =>PassOrder::class
        ];
    }
}