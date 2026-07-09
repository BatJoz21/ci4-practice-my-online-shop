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
    {
        // Input validation
        $rules = config("Validation")->productRule;
        if(!$this->validate($rules)) {
            return redirect()->back()
                             ->with("errors", $this->validator->getErrors())
                             ->withInput();
        }

        // Get uploaded file
        $file = $this->request->getFile("image");
        if(!$file->isValid()) {
            return redirect()->back()
                             ->with("errors", ["Product image is invalid"])
                             ->withInput();
        }

        // Handle API response and redirect with success/error message
        $response = $this->api->createProduct([
            "category_id"           => (int)$this->request->getPost("category_id"),
            "name"                  => $this->request->getPost("name"),
            "slug"                  => $this->request->getPost("slug"),
            "description"           => $this->request->getPost("description"),
            "price"                 => number_format($this->request->getPost("price"), 2, '.', '')
        ], $file);

        if(!$response["success"]) {
            return redirect()->back()
                             ->with("errors", [$response["message"]])
                             ->withInput();
        }

        return redirect()->to("my-products")
                         ->with("message", $response["data"]["message"]);
    }

    public function index()
    {
        $response = $this->api->getProducts();

        if($response["success"]) {
            return view("Merchants/products/index", ["products" => $response["data"]]);
        }

        return view("Products/index"); // ToDo: make a custom error page
    }

    public function show(int $id)
    {
        $response = $this->api->getProduct($id);
        if(!$response["success"]) {
            return redirect()->to("my-products")
                             ->with("error", "Product not found");
        }

        $response2 = $this->api->getVariantsOfAProduct($id);
        if(!$response["success"]) {
            return redirect()->to("my-products")
                             ->with("errors", [$response2["message"]]);
        }

        return view("Merchants/variants/show", [
            "product"   => $response["data"],
            "variants"  => $response2["data"]
        ]);
    }
}
