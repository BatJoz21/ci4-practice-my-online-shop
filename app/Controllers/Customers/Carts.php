<?php

namespace App\Controllers\Customers;

use App\Controllers\BaseController;
use App\Services\CartApiService;

class Carts extends BaseController
{
    protected CartApiService $api;
    protected Products $products;

    public function __construct()
    {
        $this->api = new CartApiService();
        $this->products = new Products();
    }

    public function addItem()
    {
        $quantity = (int)$this->request->getPost("quantity");
        $variantId = (int)$this->request->getPost("variant_id");

        $price = $this->sumItemPricePerQuantity($this->products->getProductPrice($variantId)[0]["price_snapshot"], $quantity);

        $response = $this->api->addItemToCart([
            "product_id"        => (int)$this->request->getPost("product_id"),
            "variant_id"        => $variantId,
            "quantity"          => $quantity,
            "price_snapshot"    => $price
        ]);
        if(!$response["success"]) {
            return redirect()->back()
                             ->with("errors", [$response["message"]])
                             ->withInput();
        }

        return redirect()->to("products")
                         ->with("message", $response["data"]["message"]);
    }

    public function show()
    {
        $response = $this->api->getAllItemOnCart();
        if(!$response["success"]) {
            return redirect()->to("")
                             ->with("error", $response["message"]);
        }

        return view("Cart/show", ["items" => $response["data"]]);
    }

    public function update(int $id)
    {
        $variantID = (int)$this->request->getPost("variant_id");
        $quantity = (int)$this->request->getPost("quantity");

        $newPrice = $this->sumItemPricePerQuantity($this->products->getProductPrice($variantID)[0]["price_snapshot"], $quantity);

        $response = $this->api->updateItemOnCart($id, [
            "variant_id"        => $variantID,
            "quantity"          => $quantity,
            "price_snapshot"    => $newPrice
        ]);
        if(!$response["success"]) {
            return redirect()->back()
                             ->with("errors", [$response["message"]])
                             ->withInput();
        }

        return redirect()->to("cart")
                         ->with("message", $response["data"]["message"]);
    }

    public function delete(int $id)
    {
        $response = $this->api->removeItemFromCart($id);
        if(!$response["success"]) {
            return redirect()->back()
                             ->with("errors", [$response["message"]])
                             ->withInput();
        }

        return redirect()->to("cart")
                         ->with("message", $response["data"]["message"]);
    }

    private function sumItemPricePerQuantity(string $price, string $quantity): string
    {
        $price = sprintf('%.2F', (floatval($price) * floatval($quantity)));

        return $price;
    }
}
