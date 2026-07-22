<?php

namespace App\Services;

class ReviewApiService extends BaseApiService
{
    public function createReview(array $data, int $productID)
    {
        return $this->handleRequest(function() use($data, $productID) {
            return $this->client->post("products/" . $productID . "/reviews", [
                "headers"       => $this->getHeaders(),
                "json"          => $data
            ]);
        });
    }

    public function getProductReviews(int $productID)
    {
        return $this->handleRequest(function() use($productID) {
            return $this->client->get("products/" . $productID . "/reviews", [
                "headers"       => $this->getHeaders()
            ]);
        });
    }
}
