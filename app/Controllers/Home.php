<?php

namespace App\Controllers;

use App\Services\ProductsApiService;

class Home extends BaseController
{
    protected ProductsApiService $api;

    public function __construct()
    {
        $this->api = new ProductsApiService();
    }

    public function index(): string
    {
        if(session("logged_in") && session("user")["role"] === "customer")
        {
            // Set total item in cart for header
            $responseTotal = $this->api->getTotalItemsInCart();
            $totalInCart = session("totalInCart") ?? 0;
            if($responseTotal["success"]) {
                $totalInCart = $responseTotal["data"];
            }
            session()->set("totalInCart", $totalInCart);
        }

        $response = $this->api->getStockedProducts("", "", "1");
        $products = [];
        if($response["success"]) {
            $products = $response["data"];
        }

        return view("Home/index", ["products" => $products]);
    }
}
