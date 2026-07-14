<?php

namespace App\Controllers\Merchants;

use App\Controllers\BaseController;
use App\Services\ProductsApiService;
use App\Services\ProductsVariantApiService;

class ProductVariants extends BaseController
{
    private ProductsApiService $productApi;
    private ProductsVariantApiService $api;

    public function __construct()
    {
        $this->productApi = new ProductsApiService();
        $this->api = new ProductsVariantApiService();
    }

    public function create(int $id)
    {
        $response = $this->api->createProductVariant($id, [
            "name"              => $this->request->getPost("name"),
            "sku"               => $this->request->getPost("sku"),
            "price_modifier"    => $this->request->getPost("price_modifier"),
            "stock"             => $this->request->getPost("stock")
        ]);

        if(!$response["success"]) {
            return redirect()->back()
                             ->with("errors", [$response["message"]])
                             ->withInput();
        }

        return redirect()->to("my-products/" . $id)
                         ->with("message", $response["data"]["message"]);
    }

    public function edit(int $id, int $variant_id)
    {
        $productResponse = $this->productApi->getProduct($id);
        if(!$productResponse["success"]) {
            return redirect()->to("my-products")
                             ->with("errors", [$productResponse["message"]]);
        }

        $variantResponse = $this->api->getSingleVariant($id, $variant_id);
        if(!$variantResponse["success"]) {
            return redirect()->to("my-products")
                             ->with("errors", [$variantResponse["message"]]);
        }

        return view("Variants/edit", [
            "id"        => $productResponse["data"]["id"],
            "variant"   => $variantResponse["data"]
        ]);
    }

    public function update(int $id, int $variant_id)
    {
        $variantResponse = $this->api->getSingleVariant($id, $variant_id);
        if(!$variantResponse["success"]) {
            return redirect()->to("my-products")
                             ->with("errors", [$variantResponse["message"]]);
        }

        $response = $this->api->updateProductVariant($id, $variant_id, [
            "name"              => $this->request->getPost("name"),
            "sku"               => $this->request->getPost("sku"),
            "price_modifier"    => $this->request->getPost("price_modifier"),
            "stock"             => $this->request->getPost("stock")
        ]);

        if(!$response["success"]) {
            return redirect()->back()
                             ->with("errors", [$response["message"]])
                             ->withInput();
        }

        return redirect()->to("my-products/" . $id)
                         ->with("message", $response["data"]["message"]);
    }

    public function delete(int $id, int $variant_id)
    {
        $variantResponse = $this->api->getSingleVariant($id, $variant_id);
        if(!$variantResponse["success"]) {
            return redirect()->to("my-products")
                             ->with("errors", [$variantResponse["message"]]);
        }

        $response = $this->api->deleteProductVariant($id, $variant_id);
        if(!$response["success"]) {
            return redirect()->back()
                             ->with("errors", [$response["message"]])
                             ->withInput();
        }

        return redirect()->to("my-products/" . $id)
                         ->with("message", $response["data"]["message"]);
    }
}
