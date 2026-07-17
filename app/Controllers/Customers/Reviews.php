<?php

namespace App\Controllers\Customers;

use App\Controllers\BaseController;
use App\Services\ProductsApiService;
use App\Services\ReviewApiService;

class Reviews extends BaseController
{
    protected ReviewApiService $api;
    protected ProductsApiService $productApi;

    public function __construct()
    {
        $this->api = new ReviewApiService();
        $this->productApi = new ProductsApiService();
    }

    public function new(int $productID)
    {
        $orderID = $this->request->getGet("order_id");
        if(empty($orderID)) {
            return redirect()->to("orders")
                             ->with("error", "Order's id invalid");
        }

        $response = $this->productApi->getStockedProduct($productID);
        if(!$response["success"]) {
            return redirect()->to("orders")
                             ->with("error", $response["message"]);
        }
        if(empty($response["data"])) {
            return redirect()->to("orders")
                             ->with("error", "Product not exist");
        }

        return view("Reviews/customer/create", [
            "product"   => $response["data"],
            "orderID"   => $orderID
        ]);
    }

    public function create(int $productID)
    {
        $response = $this->api->createReview([
            "order_id"      => $this->request->getPost("order_id"),
            "rating"        => (int)$this->request->getPost("rating"),
            "comment"       => $this->request->getPost("comment")
        ], $productID);
        if(!$response["success"]) {
            return redirect()->back()
                             ->with("error", $response["message"]);
        }

        return redirect()->to("orders")
                         ->with("message", $response["data"]["message"]);
    }
}
