<?php

namespace App\Controllers\Customers;

use App\Controllers\BaseController;
use App\Services\OrderApiService;

class Orders extends BaseController
{
    protected OrderApiService $api;
    protected Carts $carts;

    public function __construct()
    {
        $this->api = new OrderApiService();
        $this->carts = new Carts();
    }

    public function create()
    {
        $items = $this->carts->getItemsFromCart();
        if(empty($items)) {
            return redirect()->back()
                             ->with("error", "Cart is empty")
                             ->withInput();
        }

        $response = $this->api->generateNewOrder($this->request->getPost());

        if(!$response["success"]) {
            return redirect()->back()
                             ->with("error", $response["message"])
                             ->withInput();
        }
        $insertedItem = [];
        foreach($items as $item) {
            $response2 = $this->api->addItemToOrder([
                "order_id"                  => $response["data"]["id"],
                "product_id"                => $item["product_id"],
                "variant_id"                => $item["variant_id"],
                "product_name_snapshot"     => $item["product_name_snapshot"],
                "quantity"                  => $item["quantity"],
                "price_snapshot"            => $item["price_snapshot"]
            ]);

            if(!$response2["success"]) {
                // Empty user's order_items &  delete user's order
                if(!$this->resetOrder($insertedItem, $response["data"]["id"])) {
                    return redirect()->back()
                                     ->with("error", "Failed to reset order");
                }
                return redirect()->back()
                                 ->with("error", $response2["message"])
                                 ->withInput();
            }
            $insertedItem[] = $response2["data"]["orderItem"];

            $isRemoveFromCart = $this->carts->deleteAfterCreateOrder($item["id"]);
            if(!$isRemoveFromCart) {
                // Empty user's order_items &  delete user's order
                if(!$this->resetOrder($insertedItem, $response["data"]["id"])) {
                    return redirect()->back()
                                     ->with("error", "Failed to reset order");
                }
            }
        }

        $response3 = $this->api->populateNewOrder($response["data"]["id"]);
        if(!$response3["success"]) {
            // Empty user's order_items &  delete user's order
            if(!$this->resetOrder($insertedItem, $response["data"]["id"])) {
                return redirect()->back()
                                    ->with("error", "Failed to reset order");
            }
            return redirect()->back()
                             ->with("error", $response["message"])
                             ->withInput();
        }

        return redirect()->to("orders/" . $response["data"]["id"])
                         ->with("message", $response3["data"]["message"]);
    }

    public function index()
    {
        $response = $this->api->getOrders();
        if(!$response["success"]) {
            return redirect()->to("")
                             ->with("error", $response["message"]);
        }

        return view("Orders/index", ["orders" => $response["data"]]);
    }

    public function show(int $orderID)
    {
        $response = $this->api->getOrderDetail($orderID);
        if(!$response["success"]) {
            return redirect()->to("")
                             ->with("error", $response["message"]);
        }

        return view("Orders/show", [
            "order"         => $response["data"]["order"],
            "orderItems"    => $response["data"]["orderItems"]
        ]);
    }

    private function resetOrder(array $items, int $id)
    {
        if(!empty($items)) {
            foreach($items as $item) {
                $response = $this->api->deleteOrderItem($item["order_id"], $item["id"]);
                if(!$response["success"]) {
                    return false;
                }
            }
        }

        $response = $this->api->deleteOrder($id);
        if(!$response["success"]) {
            return false;
        }

        return true;
    }
}
