<?php

namespace App\Services;

class ProductsApiService extends BaseApiService {
    public function createProduct(
        array $data,
        ?\CodeIgniter\HTTP\Files\UploadedFile $image = null
    )
    {
        $multipart = [
            [
                "name"      => "category_id",
                "contents"  => $data["category_id"]
            ],
            [
                "name"      => "name",
                "contents"  => $data["name"]
            ],
            [
                "name"      => "slug",
                "contents"  => $data["slug"]
            ],
            [
                "name"      => "description",
                "contents"  => $data["description"]
            ],
            [
                "name"      => "price",
                "contents"  => $data["price"]
            ]
        ];

        if($image && $image->isValid()) {
            $multipart[] = [
                "name"      => "image",
                "contents"  => fopen($image->getTempName(), "r"),
                "filename"  => $image->getClientName()
            ];
        }

        return $this->handleRequest(function() use($multipart) {
            return $this->client->post("products", [
                "headers"       => $this->getHeaders(),
                "multipart"     => $multipart
            ]);
        });
    }

    public function createProductVariant(int $id, array $data)
    {
        return $this->handleRequest(function() use($id, $data) {
            return $this->client->post("products/" . $id . "/variants", [
                "headers"       => $this->getHeaders(),
                "json"          => $data
            ]);
        });
    }

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

    public function getVariantsOfAProduct(int $id)
    {
        return $this->handleRequest(function() use($id) {
            return $this->client->get("products/" . $id . "/variants", [
                "headers"       => $this->getHeaders()
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
