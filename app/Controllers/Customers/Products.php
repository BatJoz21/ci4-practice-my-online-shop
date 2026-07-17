<?php

namespace App\Controllers\Customers;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Services\ProductsApiService;
use App\Services\ReviewApiService;

class Products extends BaseController
{
    protected ProductsApiService $api;
    protected ReviewApiService $reviewApi;
    protected ProductModel $model;

    public function __construct()
    {
        $this->api = new ProductsApiService();
        $this->reviewApi = new ReviewApiService();
        $this->model = new ProductModel();
    }

    public function show(int $id)
    {
        $response = $this->api->getStockedProduct($id);
        if(!$response["success"]) {
            return redirect()->to("")
                             ->with("error", "Product not found");
        }
        $varianResponse = $this->api->getVariantsOfAProduct($id);

        $reviewResponse = $this->reviewApi->getProductReviews($id);

        return view("Products/show", [
            "product"   => $response["data"],
            "variants"  => $varianResponse["data"],
            "reviews"   => $reviewResponse["data"]
        ]);
    }

    public function getProductPrice(int $id)
    {
        $data = $this->model->select("(products.price + product_variants.price_modifier) AS price_snapshot")
                            ->join("product_variants", "products.id = product_variants.product_id")
                            ->where("product_variants.id", $id)
                            ->find();

        return $data;
    }

    public function getProductForReview(int $id)
    {
        $data = $this->model->select("id, name, image")
                            ->find($id);

        return $data;
    }
}
