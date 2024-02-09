<?php

namespace App\Controllers;

use CodeIgniter\RestFul\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\MenuModel;


class MenuController extends ResourceController
{
    public function index()
    {
        //
    }

    public function getData()
    {
        $menu = new MenuModel();
        $data = $menu->findAll();
        return $this->respond($data, 200);
    }
}
