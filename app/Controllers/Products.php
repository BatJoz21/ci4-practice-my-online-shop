<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\ProductsApiService;

class Products extends BaseController
{
    protected ProductsApiService $api;

    public function __construct()
    {
        $this->api = new ProductsApiService();
    }

    public function index()
    {
        $category_id = $this->request->getGet("category_id") ?? "";
        $search = $this->request->getGet("search") ?? "";
        $page = $this->request->getGet("page") ?? "1";

        $response = $this->api->getAllCategory();
        $categories = [];
        if($response["success"]) {
            $categories = $response["data"];
        }

        $response = $this->api->getStockedProducts($search, $category_id, $page);
        if(!$response["success"]) {
            return redirect()->to("")
                         ->with("error", $response["message"]);
        }

        $products = $response["data"] ?? [];

        $totalPages = ceil(count($products) / 5);

        return view("Products/index", [
            "products"      => $products,
            "categories"    => $categories,
            "category_id"   => $category_id,
            "search"        => $search,
            "totalPages"    => $totalPages
        ]);
    }

    public function getProductImage(int $id)
    {
        $response = $this->api->getProductImage($id);

        $body = (string) $response->getBody();

        return $this->response->setStatusCode(200)
                              ->setHeader("Content-Type", $response->getHeaderLine("Content-Type"))
                              ->setHeader("Content-Length", strlen($body))
                              ->setBody($body);
    }
}
