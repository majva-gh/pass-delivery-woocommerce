<p align="center"><img src="./socialcard.jpg" alt="Social Card of Pass Delivery API"></p>

# <a href="https://www.pass.qa/" target="_blank">Pass Delivery</a>: Api package library


## About API

See the <a href="https://www.pass.qa/integration" target="_blank">integration page</a> for description of pass delivery api.


## Documentation

See the <a href="https://passdelivery.readme.io/" target="_blank">documentation</a> for pass delivery api documentation.


## Installation

```console
composer require pass-qa/delivery
```
## Optional: 
The service provider will automatically get registered. Or you may manually add the service provider in your config/app.php file:

```console
'providers' => [
    // ...
    pass-qa\delivery\src\providers\PassDeliveryApiServiceProvider::class,
];
```
## Publish files
You should publish the config/passdelivery.php config file with:

```console
php artisan vendor:publish --provider="PassQa\Delivery\Providers\PassDeliveryApiServiceProvider"
```
After that, you should put your api_key in config file, also you can set test_mode to true for development or false for production.

## Usage Instructions

### First Step

You must generate a token. See [this page](https://passdelivery.readme.io/reference/get-api-token) to learn how to create a token.

#### create new object

```php
use PassQa\Delivery\PassOrder;

$order = new PassOrder()
```

### calculate order price before create order

Request a quote to receive your exact delivery fee for an order by using the origin address and destination addresses.

This endpoint retrieves calculation information in the format of for a pair of {latitude, longitude} coordinates.

```php
$priceData = [
        "pickup" =>[
            "lat" =>"25.275047",
            "long" => "51.535141"
        ],
        "dropoffs" => [
            [
                "lat" =>"25.277007", 
                "long" => "51.530034"
            ],
                 [
                "lat" =>"25.277005", 
                "long" => "51.530039"
                 ],
                 [
                "lat" =>"25.277001", 
                "long" => "51.530030"
                 ]
        ]
    ];
```

use object

```php
use PassQa\Delivery\PassOrder;

$order = new PassOrder();

$response = $order->Price($priceData);
```

or use facade

```php
use PassQa\Delivery\Facades\PassOrder;

$response = PassOrder::Price($priceData);
```

### create an order

Once you calculated the price of your order, you can use this endpoint in order to create a new order.

```php
$orderData = [
        "addresses"=> [
            "pickup" =>[
                "lat"=> "25.275047",
                "long"=> "51.535141",
                "name"=> "majva",
                "phone"=> "+97466661234",
                "address"=> "this street",
                "description"=> "it is a sample description"
            ],
            "dropoffs" => [
                [
                    "lat"=> "25.277007",
                    "long"=> "51.530034",
                    "name"=> "majva",
                    "phone"=> "+97466661234",
                    "address"=> "that street",
                    "description"=> "it is a sample description"
                ],
                [
                    "lat"=> "25.277007",
                    "long"=> "51.530034",
                    "name"=> "majva",
                    "phone"=> "+97466661234",
                    "address"=> "other street",
                    "description"=> "it is a sample description"
                ],
                [
                    "lat"=> "25.277007",
                    "long"=> "51.530034",
                    "name"=> "majva",
                    "phone"=> "+97466661234",
                    "address"=> "another street",
                    "description"=> "it is a sample description"
                ]
            ]
        ]
    ];
```

use object

```php
use PassQa\Delivery\PassOrder;

$order = new PassOrder();

$response = $order->Create($orderData);
```

or use facade

```php
use PassQa\Delivery\Facades\PassOrder;

$response = PassOrder::Create($orderData);
```

### tracking driver of your order

Once you successfully have created an order, you will be able to watch the Pass driver on a live map.

The driver's location and order status will be change as the driver is moving.

The 'order id' is available in the [create](#create-an-order) API response

use object

```php
use PassQa\Delivery\PassOrder;

$order = new PassOrder();

$response = $order->Tracking('order id');
```

or use facade

```php
use PassQa\Delivery\Facades\PassOrder;

$response = PassOrder::Tracking('order id');
```

### get order detail

Call the following endpoint in order to get the order details.

The order details include:
<ol>
<li>Pickup and Dropoff details including description</li>

<li>Driver details including name, phone number, avatar and vehicle information</li>

<li>Order price and payment details</li>

<li>Order statuses</li>

<li>Share URL. A tool which you can use to share a link with your clients to view the live driver status.</li>
</ol>

The 'order id' is available in the [create](#create-an-order) API response

use object

```php
use PassQa\Delivery\PassOrder;

$order = new PassOrder();

$response = $order->Detail('order id');
```

or use facade

```php
use PassQa\Delivery\Facades\PassOrder;

$response = PassOrder::Detail('order id');
```

### cancel an order

You can cancel any order before courier arrival (before the pickup status)

The 'order id' is available in the [create](#create-an-order) API response

use object

```php
use PassQa\Delivery\PassOrder;

$order = new PassOrder();

$response = $order->Cancel('order id');
```

or use facade

```php
use PassQa\Delivery\Facades\PassOrder;

$response = PassOrder::Cancel('order id');
```

### list of orders

List of all submitted orders by your tokens

use object

```php
use PassQa\Delivery\PassOrder;

$order = new PassOrder();

$response = $order->List();
```

or use facade

```php
use PassQa\Delivery\Facades\PassOrder;

$response = PassOrder::List();
```

### Security

If you discover any security-related issues, please email [security@pass.qa](mailto:security@spatie.be) instead of using the issue tracker.


## Credits

- [Mostafa](https://github.com/mostafasharami)
- [Majva](https://github.com/majva-gh)


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
