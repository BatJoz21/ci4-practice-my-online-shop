<?php

namespace App\Controllers\Customers;

use App\Controllers\BaseController;
use App\Models\ReviewModel;
use App\Services\ReviewApiService;

class Reviews extends BaseController
{
    protected ReviewApiService $api;
    protected ReviewModel $model;
    protected Products $products;

    public function __construct()
    {
        $this->api = new ReviewApiService();
        $this->model = new ReviewModel();
        $this->products = new Products();
    }

    public function new(int $productID)
    {
        $orderID = $this->request->getGet("order_id");
        if(empty($orderID)) {
            return redirect()->to("orders")
                             ->with("error", "Order's id invalid");
        }

        if(!$this->isAvailableToReview($productID, $orderID)) {
            return redirect()->to("orders/" . $orderID)
                             ->with("error", "Product has been reviewed");
        }

        $data = $this->products->getProductForReview($productID);

        return view("Reviews/customer/create", [
            "product"   => $data,
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

    private function isAvailableToReview(int $productID, int $orderID):bool
    {
        $data = $this->model->select("id")
                            ->where("product_id", $productID)
                            ->where("order_id", $orderID)
                            ->find();
        if(!empty($data)) {
            return false;
        }

        return true;
    }
}
