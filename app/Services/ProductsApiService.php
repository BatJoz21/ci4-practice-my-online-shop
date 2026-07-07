<?php

namespace App\Services;

class ProductsApiService extends BaseApiService {
    public function getAllCategory()
    {
        return $this->handleRequest(function() {
            return $this->client->get("categories", []);
        });
    }

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

    public function getProduct(int $id)
    {
        return $this->handleRequest(function() use($id) {
            return $this->client->get("products/" . $id, [
                "headers"       => $this->getHeaders()
            ]);
        });
    }
}
