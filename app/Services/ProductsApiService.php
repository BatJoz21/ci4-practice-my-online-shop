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

    public function getAllCategory()
    {
        return $this->handleRequest(function() {
            return $this->client->get("categories", []);
        });
    }

    public function getProducts()
    {
        return $this->handleRequest(function() {
            return $this->client->get("products/all", [
                "headers"       => $this->getHeaders()
            ]);
        });
    }

    public function getStockedProducts()
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
            return $this->client->get("products/all/" . $id, [
                "headers"       => $this->getHeaders()
            ]);
        });
    }

    public function getStockedProduct(int $id)
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

    public function updateProducts(
        int $id,
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

        return $this->handleRequest(function() use($id, $multipart) {
            return $this->client->put("products/" . $id, [
                "headers"       => $this->getHeaders(),
                "multipart"     => $multipart
            ]);
        });
    }
}
