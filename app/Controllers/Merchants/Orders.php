<?php

namespace App\Controllers\Merchants;

use App\Controllers\BaseController;
use App\Services\OrderApiService;

class Orders extends BaseController
{
    protected OrderApiService $api;

    public function __construct()
    {
        $this->api = new OrderApiService();
    }

    public function index()
    {
        $status = "all";
        if(!empty($this->request->getGet("status"))) {
            $status = $this->request->getGet("status");
        }

        $response = $this->api->getOrdersForMerchant($status);
        if(!$response["success"]) {
            return redirect()->to("")
                             ->with("error", $response["message"]);
        }

        return view("Orders/merchants/index", [
            "orders"        => $response["data"],
            "currentStatus" => $status
        ]);
    }

    public function show(int $orderID)
    {
        $response = $this->api->getOrderDetailForMerchant($orderID);
        if(!$response["success"]) {
            return redirect()->to("")
                             ->with("message", $response["message"]);
        }

        return view("Orders/merchants/show", [
            "order"         => $response["data"]["order"],
            "orderItems"    => $response["data"]["orderItems"]
        ]);
    }

    public function update(int $orderID)
    {
        $response = $this->api->updateOrder([
            "status"            => $this->request->getPost("status"),
            "shipping_address"  => $this->request->getPost("shipping_address"),
            "estimated_arrival" => $this->request->getPost("estimated_arrival")
        ], $orderID);
        if(!$response["success"]) {
            return redirect()->back()
                             ->with("message", $response["message"]);
        }

        return redirect()->to("merchant/orders")
                         ->with("message", "Success editing order");
    }
}
