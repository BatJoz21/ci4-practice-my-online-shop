<?php

namespace App\Services;

class PaymentApiService extends BaseApiService
{
    public function initiatePayment(int $orderID)
    {
        return $this->handleRequest(function() use($orderID) {
            $this->client->post("orders/" . $orderID . "/payment", [
                "headers"       => $this->getHeaders()
            ]);
        });
    }
}
