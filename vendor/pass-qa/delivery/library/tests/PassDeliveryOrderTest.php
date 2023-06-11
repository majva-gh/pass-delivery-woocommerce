<?php

namespace PassQa\Delivery\Library\Tests;

use PassQa\Delivery\PassOrder;


class PassDeliveryOrderTest extends PassTestCase
{

    public function testList()
    {
        $order = new PassOrder();
        $orders = $order->list();
        $this->assertTrue($orders['status'] === "success");
    }

    public function testCreate()
    {
        $order = new PassOrder();
        $orderData = $this->prepareCreateOrderData();
        $order = $order->create($orderData);
        $this->assertTrue($order['status'] === "success");
    }

    public function testPrice()
    {
        $order = new PassOrder();
        $priceData = $this->preparePriceData();
        $order = $order->price($priceData);
        $this->assertTrue($order['status'] === "success");
    }

    public function testDetail()
    {
        $order = new PassOrder();
        $createdOrder = $order->create($this->prepareCreateOrderData());
        $orderDetails = $order->detail($createdOrder['data']['order_id']);
        $this->assertTrue($orderDetails['status'] === "success");
    }

    public function testTracking()
    {
        $order = new PassOrder();
        $createdOrder = $order->create($this->prepareCreateOrderData());
        $orderTracking = $order->tracking($createdOrder['data']['order_id']);
        $this->assertTrue($orderTracking['status'] === "success");
    }

    public function testCancel()
    {
        $order = new PassOrder();
        $createdOrder = $order->create($this->prepareCreateOrderData());
        $canceledResponse = $order->cancel($createdOrder['data']['order_id']);
        $this->assertTrue($canceledResponse['status'] === "success");
    }

    private function prepareCreateOrderData(): array
    {
        return [
            "addresses" => [
                "pickup"   => [
                    "lat"         => "25.275047",
                    "long"        => "51.535141",
                    "name"        => "majva",
                    "phone"       => "+97466661234",
                    "address"     => "this street",
                    "description" => "it is a sample description"
                ],
                "dropoffs" => [
                    [
                        "lat"         => "25.277007",
                        "long"        => "51.530034",
                        "name"        => "majva",
                        "phone"       => "+97466661234",
                        "address"     => "that street",
                        "description" => "it is a sample description"
                    ],
                    [
                        "lat"         => "25.277007",
                        "long"        => "51.530034",
                        "name"        => "majva",
                        "phone"       => "+97466661234",
                        "address"     => "other street",
                        "description" => "it is a sample description"
                    ],
                    [
                        "lat"         => "25.277007",
                        "long"        => "51.530034",
                        "name"        => "majva",
                        "phone"       => "+97466661234",
                        "address"     => "another street",
                        "description" => "it is a sample description"
                    ]
                ]
            ]
        ];
    }

    private function preparePriceData(): array
    {
        return [
            "pickup"   => [
                "lat"  => "25.275047",
                "long" => "51.535141"
            ],
            "dropoffs" => [
                [
                    "lat"  => "25.277007",
                    "long" => "51.530034"
                ],
                [
                    "lat"  => "25.277005",
                    "long" => "51.530039"
                ],
                [
                    "lat"  => "25.277001",
                    "long" => "51.530030"
                ]
            ]
        ];
    }
}