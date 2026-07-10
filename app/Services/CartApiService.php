<?php

namespace App\Services;

class CartApiService extends BaseApiService
{
    public function addItemToCart(array $data)
    {
        return $this->handleRequest(function() use($data) {
            return $this->client->post("addToCart", [
                "headers"       => $this->getHeaders(),
                "json"          => $data
            ]);
        });
    }

    public function getAllItemOnCart()
    {
        return $this->handleRequest(function() {
            return $this->client->get("carts", [
                "headers"       => $this->getHeaders()
            ]);
        });
    }

    public function updateItemOnCart(int $id, array $data)
    {
        return $this->handleRequest(function() use($id, $data) {
            return $this->client->put("carts/" . $id, [
                "headers"       => $this->getHeaders(),
                "json"          => $data
            ]);
        });
    }

    public function removeItemFromCart(int $id)
    {
        return $this->handleRequest(function() use($id) {
            return $this->client->delete("carts/" . $id, [
                "headers"       => $this->getHeaders()
            ]);
        });
    }
}
