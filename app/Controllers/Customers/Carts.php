<?php

namespace App\Controllers\Customers;

use App\Controllers\BaseController;
use App\Models\CartModel;
use App\Services\CartApiService;

class Carts extends BaseController
{
    protected CartApiService $api;
    protected Products $products;
    protected CartModel $model;

    public function __construct()
    {
        $this->api = new CartApiService();
        $this->products = new Products();
        $this->model = new CartModel();
    }

    public function addItem()
    {
        $quantity = (int)$this->request->getPost("quantity");
        $variantId = (int)$this->request->getPost("variant_id");

        $price = $this->products->getProductPrice($variantId)[0]["price_snapshot"];

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

        // Set total item in cart for header
        $responseTotal = $this->api->getTotalItemsInCart();
        $totalInCart = session("totalInCart") ?? 0;
        if($responseTotal["success"]) {
            $totalInCart = $responseTotal["data"];
        }
        session()->set("totalInCart", $totalInCart);

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

        // Set total item in cart for header
        $responseTotal = $this->api->getTotalItemsInCart();
        $totalInCart = session("totalInCart") ?? 0;
        if($responseTotal["success"]) {
            $totalInCart = $responseTotal["data"];
        }
        session()->set("totalInCart", $totalInCart);

        return view("Cart/show", ["items" => $response["data"]]);
    }

    public function showCheckOut()
    {
        $response = $this->api->getAllItemOnCart();
        if(!$response["success"]) {
            return redirect()->to("")
                             ->with("error", $response["message"]);
        }

        return view("Cart/checkout", ["items" => $response["data"]]);
    }

    public function getCartID()
    {
        $data = $this->model->select("id")
                            ->where("user_id", session("user")["id"])
                            ->find();

        return (int)$data[0]["id"];
    }

    public function getItemsFromCart()
    {
        $data = $this->model->select("cart_items.id, cart_items.cart_id, cart_items.product_id, 
                                        cart_items.variant_id, cart_items.quantity, cart_items.price_snapshot,
                                        CONCAT(products.name, ' Size ', product_variants.name) as product_name_snapshot")
                            ->join("cart_items", "carts.id = cart_items.cart_id")
                            ->join("products", "cart_items.product_id = products.id")
                            ->join("product_variants", "cart_items.variant_id = product_variants.id")
                            ->where("carts.user_id", session("user")["id"])
                            ->findAll();

        return $data;
    }

    public function update(int $id)
    {
        $variantID = (int)$this->request->getPost("variant_id");
        $quantity = (int)$this->request->getPost("quantity");

        $newPrice = $this->products->getProductPrice($variantID)[0]["price_snapshot"];

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

        // Set total item in cart for header
        $responseTotal = $this->api->getTotalItemsInCart();
        $totalInCart = session("totalInCart") ?? 0;
        if($responseTotal["success"]) {
            $totalInCart = $responseTotal["data"];
        }
        session()->set("totalInCart", $totalInCart);

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

        // Set total item in cart for header
        $responseTotal = $this->api->getTotalItemsInCart();
        $totalInCart = session("totalInCart") ?? 0;
        if($responseTotal["success"]) {
            $totalInCart = $responseTotal["data"];
        }
        session()->set("totalInCart", $totalInCart);

        return redirect()->to("cart")
                         ->with("message", $response["data"]["message"]);
    }

    public function deleteAfterCreateOrder(int $id):bool
    {
        $response = $this->api->removeItemFromCart($id);
        if(!$response["success"]) {
            return false;
        }

        return true;
    }
}
