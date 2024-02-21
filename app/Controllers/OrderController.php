<?php

namespace App\Controllers;

use CodeIgniter\RestFul\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\MenuModel;

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
    public function getDataBySession($sessionId)
    {
        $order = new OrderModel();

        // Fetch orders based on $sessionId
        $orders = $order->where('session_id', $sessionId)->findAll();

        return $this->respond($orders); // Adjust this according to your response format
    }

    public function deleteOrder($id)
    {
        $order = new OrderModel();
        $r = $order->delete($id);

        return $this->respondDeleted();
    }
    // Add this method to your OrderController
    public function getOrderCount($sessionId)
    {
        $orderModel = new OrderModel();

        // Fetch the count of orders with the specified session_id
        $orderCount = $orderModel->where('session_id', $sessionId)->countAllResults();

        return $this->respond(['count' => $orderCount], 200);
    }

    public function getOrderData($id)
    {
        $orderModel = new OrderModel();

        // Fetch order data based on the provided order ID
        $orderData = $orderModel->find($id);

        if ($orderData) {
            // Order data found, respond with success and data
            return $this->respond(['status' => 'success', 'id' => $id, 'data' => $orderData], 200);
        } else {
            // Order data not found, respond with an error
            return $this->respond(['status' => 'not_found', 'id' => $id], 404);
        }
    }


    public function addData()
    {
        $json = $this->request->getJSON();

        // Create the order data
        $orderData = [
            'session_id' => $json->session_id,
        ];

        $order = new OrderModel();
        $r = $order->insert($orderData);

        return $this->respond($r, 200);
    }

    public function addItemToOrder()
    {
        $json = $this->request->getJSON();
        $orderItemModel = new OrderItemModel();

        // Check if the order item already exists for the given order and menu item
        $existingOrderItem = $orderItemModel->where('order_id', $json->order_id)
            ->where('menu_item', $json->menu_item)
            ->first();

        if ($existingOrderItem) {
            // If the order item already exists, update quantity and subtotal
            $quantity = $existingOrderItem['quantity'] + 1;
            $subtotal = $json->subtotal * $quantity;

            $orderItemModel->update($existingOrderItem['id'], [
                'quantity' => $quantity,
                'subtotal' => $subtotal,
            ]);

            $response = ['status' => 'updated', 'id' => $existingOrderItem['id']];
        } else {
            // If the order item doesn't exist, insert a new order item
            $orderData = [
                'order_id'   => $json->order_id,
                'menu_item'  => $json->menu_item,
                'quantity'   => 1,
                'subtotal'   => $json->subtotal,
            ];

            $response = $orderItemModel->insert($orderData);
        }

        $totalOrderPrice = $this->calculateTotalOrderPrice($json->order_id);
        $orderModel = new OrderModel();
        $orderModel->update($json->order_id, ['total_order_price' => $totalOrderPrice]);

        return $this->respond(['status' => 'success', 'id' => $json->order_id, 'total_order_price' => $totalOrderPrice], 200);
    }

    public function getOrderItems($id)
    {
        // Assuming $id is the order ID you want to retrieve order items for
        $orderItemModel = new OrderItemModel();

        // Fetch order items based on the provided order ID
        $orderItems = $orderItemModel->where('order_id', $id)->findAll();

        // You can then respond with the retrieved order items
        return $this->respond($orderItems, 200);
    }


    public function updateOrderItem($id)
    {
        $json = $this->request->getJSON();
        $orderItemModel = new OrderItemModel();
        $menuModel = new MenuModel();

        // Fetch the order item by ID
        $orderItem = $orderItemModel->find($id);

        // Fetch the menu item by name to get the price
        $menuItem = $menuModel->where('name', $orderItem['menu_item'])->first();

        if ($menuItem) {
            // Calculate the updated subtotal based on the updated quantity and menu item price
            $updatedSubtotal = $menuItem['price'] * $json->quantity;

            // Check if the updated quantity is zero, delete the order item
            if ($json->quantity === 0) {
                $response = $orderItemModel->delete($id);
            } else {
                // Update the order item with the new quantity and subtotal
                $data = [
                    'quantity' => $json->quantity,
                    'subtotal' => $updatedSubtotal
                ];

                $response = $orderItemModel->update($id, $data);
            }

            // Recalculate total order price
            $totalOrderPrice = $this->calculateTotalOrderPrice($orderItem['order_id']);
            $orderModel = new OrderModel();
            $orderModel->update($orderItem['order_id'], ['total_order_price' => $totalOrderPrice]);

            return $this->respond($response, 200);
        } else {
            // Menu item not found
            return $this->respond(['status' => 'menu_item_not_found'], 404);
        }
    }


    protected function calculateTotalOrderPrice($orderId)
    {
        $orderItemModel = new OrderItemModel();

        // Fetch order items based on the provided order ID
        $orderItems = $orderItemModel->where('order_id', $orderId)->findAll();

        // Calculate total order price based on order items
        $totalOrderPrice = 0;
        foreach ($orderItems as $orderItem) {
            $totalOrderPrice += $orderItem['subtotal'];
        }

        return $totalOrderPrice;
    }


    public function deleteOrderItem($id)
    {
        $orderItemModel = new OrderItemModel();

        // Check if the order item exists before deleting
        $existingOrderItem = $orderItemModel->find($id);

        if ($existingOrderItem) {
            // Delete the order item with the provided ID
            $orderItemModel->delete($id);

            // Recalculate total order price
            $totalOrderPrice = $this->calculateTotalOrderPrice($existingOrderItem['order_id']);
            $orderModel = new OrderModel();
            $orderModel->update($existingOrderItem['order_id'], ['total_order_price' => $totalOrderPrice]);

            return $this->respond(['status' => 'deleted', 'id' => $id, 'total_order_price' => $totalOrderPrice], 200);
        } else {
            // Order item not found
            return $this->respond(['status' => 'not_found'], 404);
        }
    }

    public function addPayment($id)
    {
        $json = $this->request->getJSON();

        // Update the 'tendered', 'change1', and 'status' fields in the 'orders' table
        $orderModel = new OrderModel();
        $orderModel->update($id, [
            'tendered' => $json->tendered,
            'change1'  => $json->change1,
            'status'   => $json->status,
        ]);

        return $this->respond(['status' => 'success', 'id' => $id], 200);
    }
}
