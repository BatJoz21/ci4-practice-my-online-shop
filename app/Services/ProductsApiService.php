<?php

namespace App\Services;

class ProductsApiService extends BaseApiService {
    public function getProducts()
    {
        return $this->handleRequest(function() {
            return $this->client->get("products", []);
        });
    }

    public function getProductImage(int $id)
    {
        return $this->client->get("products/" . $id . "/image", []);
    }

    public function getAllCategory()
    {
        return $this->handleRequest(function() {
            return $this->client->get("categories", []);
        });
    }
}
