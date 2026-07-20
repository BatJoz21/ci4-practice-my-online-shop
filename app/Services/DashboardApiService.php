<?php

namespace App\Services;

class DashboardApiService extends BaseApiService
{
    public function getDashboardStats()
    {
        return $this->handleRequest(function() {
            return $this->client->get("merchant/dashboard/stats", [
                "headers"   => $this->getHeaders()
            ]);
        });
    }

    public function getRecentOrders()
    {
        return $this->handleRequest(function() {
            return $this->client->get("merchant/dashboard/orders", [
                "headers"   => $this->getHeaders()
            ]);
        });
    }

    public function getLowStockedProducts()
    {
        return $this->handleRequest(function() {
            return $this->client->get("merchant/dashboard/low-stocked", [
                "headers"   => $this->getHeaders()
            ]);
        });
    }

    public function getRecentReviews()
    {
        return $this->handleRequest(function() {
            return $this->client->get("merchant/dashboard/review", [
                "headers"   => $this->getHeaders()
            ]);
        });
    }
}
