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
        $stats = $responseStats["data"] ?? [];

        $responseOrders = $this->api->getRecentOrders();
        $recentOrders = $responseOrders["data"] ?? [];

        $responseStock = $this->api->getLowStockedProducts();
        $lowStocked = $responseStock["data"] ?? [];

        $responseReview = $this->api->getRecentReviews();
        $reviews = $responseReview["data"] ?? [];

        return view("Home/dashboard", [
            "stats"         => $stats,
            "recentOrders"  => $recentOrders,
            "lowStockItems" => $lowStocked,
            "reviews"       => $reviews
        ]);
    }
}
