<?php

namespace App\Services;

class ProductsVariantApiService extends BaseApiService {
    public function createProductVariant(int $id, array $data)
    {
        return $this->handleRequest(function() use($id, $data) {
            return $this->client->post("products/" . $id . "/variants", [
                "headers"       => $this->getHeaders(),
                "json"          => $data
            ]);
        });
    }
    
    public function getSingleVariant(int $id, int $variant_id)
    {
        return $this->handleRequest(function() use($id, $variant_id) {
            return $this->client->get("products/" . $id . "/variants/" . $variant_id, [
                "headers"       => $this->getHeaders()
            ]);
        });
    }

    public function updateProductVariant(int $id, int $variant_id, array $data)
    {
        return $this->handleRequest(function() use($id, $variant_id, $data) {
            return $this->client->put("products/" . $id . "/variants/" . $variant_id, [
                "headers"       => $this->getHeaders(),
                "json"          => $data
            ]);
        });
    }

    public function deleteProductVariant(int $id, int $variant_id)
    {
        return $this->handleRequest(function() use($id, $variant_id) {
            return $this->client->delete("products/" . $id . "/variants/" . $variant_id, [
                "headers"       => $this->getHeaders()
            ]);
        });
    }
}
