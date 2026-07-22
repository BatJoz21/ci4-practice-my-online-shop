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

    public function getOrdersForMerchant(string $page, string $status, string $filter, string $search)
    {
        $uri = "merchant/orders?page=" . $page;
        if(!empty($status) && $status != "" && $status != "all") {
            $uri = $uri . "&status=" . $status;
        }

        if(!empty($filter) && !empty($search)) {
            $uri = $uri . "&filter=" . esc($filter) . "&search=" . esc($search);
        }

        return $this->handleRequest(function() use($uri) {
            return $this->client->get($uri, [
                "headers"       => $this->getHeaders()
            ]);
        });
    }

    public function getOrders(string $status, string $page)
    {
        $uri = "orders?page=" . $page;
        if(!empty($status) && $status != "" && $status != "all") {
            $uri = $uri . "&status=" . $status;
        }

        return $this->handleRequest(function() use($uri) {
            return $this->client->get($uri, [
                "headers"       => $this->getHeaders()
            ]);
        });
    }

    public function getOrderDetailForMerchant(int $orderID)
    {
        return $this->handleRequest(function() use($orderID) {
            return $this->client->get("merchant/orders/" . $orderID, [
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

    public function getOrderItems(int $orderID)
    {
        return $this->handleRequest(function() use($orderID) {
            return $this->client->get("orders/" . $orderID . "/items", [
                "headers"       => $this->getHeaders()
            ]);
        });
    }

    public function updateOrder(array $data, int $orderID)
    {
        return $this->handleRequest(function() use($data, $orderID) {
            return $this->client->put("merchant/orders/" . $orderID, [
                "headers"       => $this->getHeaders(),
                "json"          => $data
            ]);
        });
    }

    public function changeStatusOrder(int $orderID, string $status)
    {
        return $this->handleRequest(function() use($orderID, $status) {
            return $this->client->put("orders/" . $orderID . "/complete" , [
                "headers"       => $this->getHeaders(),
                "json"          => [
                    "status"    => $status
                ]
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
