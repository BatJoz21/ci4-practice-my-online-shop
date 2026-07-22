<?php

namespace App\Controllers\Customers;

use App\Controllers\BaseController;
use App\Models\PaymentModel;
use App\Services\PaymentApiService;

class Payments extends BaseController
{
    protected PaymentApiService $api;
    protected PaymentModel $model;

    public function __construct()
    {
        $this->api = new PaymentApiService();
        $this->model = new PaymentModel();
    }

    public function pay(int $orderID)
    {
        $response = $this->api->initiatePayment($orderID);
        if(!$response["success"]) {
            return redirect()->to("orders/" . $orderID)
                             ->with("error", "Unable to start payment: " . $response["message"]);
        }

        if(empty($response["data"]["redirect_url"])) {
            return redirect()->to("orders/" . $orderID)
                             ->with("error", "Payment couldn't be started, please try again later");
        }

        return redirect()->to($response["data"]["redirect_url"]);
    }

    public function paymentResult(int $orderID)
    {
        return view("Payments/customer/result", ["orderID" => $orderID]);
    }
}
