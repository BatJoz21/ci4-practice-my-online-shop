<?php

namespace App\Services;

class OrderApiService extends BaseApiService
{
    public function generateNewOrder(array $data)
    {
        return $this->handleRequest(function() use($data) {
            return $this->client->post("orders", [
                "headers"       => $this->getHeaders(),
                "json"          => $data
            ]);
        });
    }

    public function addItemToOrder(array $data)
    {
        return $this->handleRequest(function() use($data) {
            return $this->client->post("orders/" . $data["order_id"] . "/items", [
                "headers"       => $this->getHeaders(),
                "json"          => $data
            ]);
        });
    }

    public function populateNewOrder(int $orderID)
    {
        return $this->handleRequest(function() use($orderID) {
            return $this->client->put("orders/" . $orderID . "/populate", [
                "headers"       => $this->getHeaders()
            ]);
        });
    }

    public function getOrders()
    {
        return $this->handleRequest(function() {
            return $this->client->get("orders", [
                "headers"       => $this->getHeaders()
            ]);
        });
    }

    public function getOrderDetail(int $orderID)
    {
        return $this->handleRequest(function() use($orderID) {
            return $this->client->get("orders/" . $orderID, [
                "headers"       => $this->getHeaders()
            ]);
        });
    }

    public function deleteOrderItem(int $orderID, int $orderItemID)
    {
        return $this->handleRequest(function() use($orderID, $orderItemID) {
            return $this->client->delete("orders/" . $orderID . "/items/" . $orderItemID, [
                "headers"       => $this->getHeaders()
            ]);
        });
    }

    public function deleteOrder(int $orderID)
    {
        return $this->handleRequest(function() use($orderID) {
            return $this->client->delete("orders/" . $orderID, [
                "headers"       => $this->getHeaders()
            ]);
        });
    }
}
