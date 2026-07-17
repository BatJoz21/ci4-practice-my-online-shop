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
            return $this->client->post("merchant/products", [
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
            return $this->client->get("merchant/products", [
                "headers"       => $this->getHeaders()
            ]);
        });
    }

    public function getStockedProducts(string $search, string $category)
    {
        $uri = "products";

        if(!empty($category)) {
            $uri = $uri . "?category_id=" . $category;

            if(!empty($search)) {
                $uri = $uri . "&search=" . $search;
            }
        } else {
            if(!empty($search)) {
                $uri = $uri . "?search=" . $search;
            }
        }

        return $this->handleRequest(function() use($uri) {
            return $this->client->get($uri, []);
        });
    }

    public function getProductImage(int $id)
    {
        return $this->client->get("products/" . $id . "/image", []);
    }

    public function getProduct(int $id)
    {
        return $this->handleRequest(function() use($id) {
            return $this->client->get("merchant/products/" . $id, [
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
            return $this->client->put("merchant/products/" . $id, [
                "headers"       => $this->getHeaders(),
                "multipart"     => $multipart
            ]);
        });
    }

    public function deleteProduct(int $id)
    {
        return $this->handleRequest(function() use($id) {
            return $this->client->delete("merchant/products/" . $id . "/delete" , [
                "headers"       => $this->getHeaders()
            ]);
        });
    }
}
