<?php

namespace App\Controllers;

use CodeIgniter\RestFul\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\OrderModel;

class OrderController extends ResourceController
{
    public function index()
    {
        //
    }
    public function getData()
    {
        $order = new OrderModel();
        $data = $order->findAll();
        return $this->respond($data, 200);
    }
}
