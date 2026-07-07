<?php

namespace App\Controllers\Customers;

use App\Controllers\BaseController;
use App\Services\ProductsApiService;

class Products extends BaseController
{
    protected ProductsApiService $api;

    public function __construct()
    {
        $this->api = new ProductsApiService();
    }

    public function show(int $id)
    {
        $response = $this->api->getProduct($id);

        if($response["success"]) {
            $varianResponse = $this->api->getVariantsOfAProduct($id);

            return view("Products/show", [
                "product"   => $response["data"],
                "variants"  => $varianResponse["data"]
            ]);
        }

        return view("Products/index"); // ToDo: make a custom error page 
    }
}
