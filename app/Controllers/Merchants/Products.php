<?php

namespace App\Controllers\Merchants;

use App\Controllers\BaseController;
use App\Services\ProductsApiService;

class Products extends BaseController
{
    protected ProductsApiService $api;

    public function __construct()
    {
        $this->api = new ProductsApiService();
    }

    public function new()
    {
        $response = $this->api->getAllCategory();
        $categories = [];
        if($response["success"]) {
            $categories = $response["data"];
        }

        return view("Merchants/products/create", ["categories" => $categories]);
    }

    public function create()
    {}

    public function index()
    {
        $response = $this->api->getProducts();

        if($response["success"]) {
            return view("Merchants/products/index", ["products" => $response["data"]]);
        }

        return view("Products/index"); // ToDo: make a custom error page
    }
}
