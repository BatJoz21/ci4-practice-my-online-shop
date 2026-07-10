<?php

namespace App\Controllers\Customers;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Services\ProductsApiService;

class Products extends BaseController
{
    protected ProductsApiService $api;
    protected ProductModel $model;

    public function __construct()
    {
        $this->api = new ProductsApiService();
        $this->model = new ProductModel();
    }

    public function show(int $id)
    {
        $response = $this->api->getStockedProduct($id);

        if($response["success"]) {
            $varianResponse = $this->api->getVariantsOfAProduct($id);

            return view("Products/show", [
                "product"   => $response["data"],
                "variants"  => $varianResponse["data"]
            ]);
        }

        return redirect()->to("")
                         ->with("error", "Product not found");
    }

    public function getProductPrice(int $id)
    {
        $data = $this->model->select("(products.price + product_variants.price_modifier) AS price_snapshot")
                            ->join("product_variants", "products.id = product_variants.product_id")
                            ->where("product_variants.id", $id)
                            ->find();

        return $data;
    }
}
