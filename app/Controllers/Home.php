<?php

namespace App\Controllers;

use App\Services\BaseApiService;

class Home extends BaseController
{
    protected BaseApiService $api;

    public function __construct()
    {
        $this->api = new BaseApiService();
    }

    public function index(): string
    {
        // Set total item in cart for header
        $responseTotal = $this->api->getTotalItemsInCart();
        $totalInCart = session("totalInCart") ?? 0;
        if($responseTotal["success"]) {
            $totalInCart = $responseTotal["data"];
        }
        session()->set("totalInCart", $totalInCart);

        return view('Home/index');
    }
}
