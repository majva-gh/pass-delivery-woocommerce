<?php

namespace PassQa\Delivery\Providers;

use Illuminate\Support\ServiceProvider;
use PassQa\Delivery\PassOrder;

class PassDeliveryApiServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/pass-delivery.php' => base_path('config/pass-delivery.php'),
        ],'pass-delivery-config');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/pass-delivery.php',
            'pass-delivery');

        $this->app->bind('pass-order', function () {
            return new PassOrder();
        });
    }
}