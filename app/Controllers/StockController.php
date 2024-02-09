<?php

namespace App\Controllers;

    use CodeIgniter\RestFul\ResourceController;
    use CodeIgniter\API\ResponseTrait;
    use App\Models\StockModel;

class StockController extends ResourceController
{
    public function index()
    {
        //
    }

    public function getData()
    {
        $stock = new StockModel();
        $data = $stock->findAll();
        return $this->respond($data, 200);
    }
}
