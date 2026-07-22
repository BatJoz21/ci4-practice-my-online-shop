<?php

namespace App\Controllers\Merchants;

use App\Controllers\BaseController;
use App\Models\PaymentModel;

class Payments extends BaseController
{
    protected PaymentModel $model;

    public function __construct()
    {
        $this->model = new PaymentModel();
    }

    public function getAllPaymentHistory()
    {
        $query = $this->model->select("orders.order_number as order_number,
                                        payments.provider as provider,
                                        payments.transaction_id as transaction_id,
                                        payments.status as status,
                                        payments.amount as amount,
                                        payments.paid_at as paid_at")
                             ->join("orders", "payments.order_id = orders.id");

        $ordNum = $this->request->getGet("ord-num") ?? "";
        if(!empty($ordNum)) {
            $query = $query->like("order_number", $ordNum);
        }

        $order = $this->request->getGet("order");
        $direction = $this->request->getGet("direction") ?? "DESC";
        if(!empty($order)) {
            $query = $query->orderBy("payments." . $order, $direction);
        } else {
            $query = $query->orderBy("payments.id", $direction);
        }

        $data = $query->paginate(15);

        return view("Payments/merchant/index", [
            "payments"      => $data,
            "direction"     => $direction,
            "search"        => $ordNum,
            "pager"         => $this->model->pager
        ]);
    }
}
