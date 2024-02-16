<?php

namespace App\Controllers;

use CodeIgniter\RestFul\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\OrderModel;
use App\Models\OrderItemModel;

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

    public function addData()
    {
        $json = $this->request->getJSON();

        // Create the order data
        $orderData = [
            'session_id' => $json->session_id,
            'total_order_price' => $json->total_order_price,
        ];

        $order = new OrderModel();
        $order->save($orderData);

        // Get the ID of the newly inserted order
        $orderId = $order->getInsertID();

        // Create the order item data
        $orderItemData = [
            'order_id' => $orderId,
            'menu_item' => $json->menu_item,
            'quantity' => $json->quantity,
            'subtotal' => $json->subtotal,
        ];

        $orderItem = new OrderItemModel();
        $orderItem->save($orderItemData);

        return $this->respond(['id' => $orderId], 200);
    }


    public function getLatestOrderId()
    {
        $order = new OrderModel();
        $latestOrder = $order->orderBy('id', 'DESC')->first();

        if ($latestOrder) {
            return $this->respond(['id' => $latestOrder['id']], 200);
        } else {
            return $this->fail('No orders found', 404);
        }
    }

    public function updateTotalOrderPrice($id)
    {
        // Get JSON data from the request
        $json = $this->request->getJSON();

        $orderModel = new OrderModel();

        // Find the order by ID
        $data = [
            'total_order_price' => $json->totalOrderPrice,
        ];

        $orderModel->update($id, $data);
    }


}
