<?php

namespace App\Controllers\Merchants;

use App\Controllers\BaseController;
use App\Services\DashboardApiService;

class Home extends BaseController
{
    protected DashboardApiService $api;

    public function __construct()
    {
        $this->api = new DashboardApiService();
    }    

    public function dashboard()
    {
        $responseStats = $this->api->getDashboardStats();
        if(!$responseStats["success"]) {
            return redirect()->to("");
        }
        $stats = $responseStats["data"];

        $responseOrders = $this->api->getRecentOrders();
        if(!$responseOrders["success"]) {
            return redirect()->to("");
        }
        $recentOrders = $responseOrders["data"];

        $responseStock = $this->api->getLowStockedProducts();
        if(!$responseStock["success"]) {
            return redirect()->to("");
        }
        $lowStocked = $responseStock["data"];

        $responseReview = $this->api->getRecentReviews();
        if(!$responseReview["success"]) {
            return redirect()->to("");
        }
        $reviews = $responseReview["data"];

        return view("Home/dashboard", [
            "stats"         => $stats,
            "recentOrders"  => $recentOrders,
            "lowStockItems" => $lowStocked,
            "reviews"       => $reviews
        ]);
    }
}
