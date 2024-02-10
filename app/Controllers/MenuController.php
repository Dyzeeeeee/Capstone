<?php

namespace App\Controllers;

use CodeIgniter\RestFul\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\MenuModel;
use App\Models\ImageModel;


class MenuController extends ResourceController
{
    use ResponseTrait;

    public function index()
    {
        //
    }

    public function deleteData($id)
{
    $menu = new MenuModel();
    $r = $menu->delete($id);

    return $this->respondDeleted();
}

    public function getData()
    {
        $menu = new MenuModel();
        $data = $menu->findAll();
        return $this->respond($data, 200);
    }

    public function addData()
    {
        $json = $this->request->getJSON();

        // Get the uploaded image file

        // Move the uploaded image to the desired directory

        $data = [
            'name' => $json->name,
            'description' => $json->description,
            'price' => $json->price,
            'category' => $json->category,
            'image' =>'http://capstone.test/Backend/public/uploads/'. $json->image,
        ];

        // Check if the 'image' field exists in the uploaded files

        $menu = new menuModel();
        $r = $menu->save($data);
        return $this->respond($r, 200);
    }


    public function uploadImage()
    {
        $uploadedFile = $this->request->getFile('image');

        if ($uploadedFile->isValid() && !$uploadedFile->hasMoved()) {
            $originalName = $uploadedFile->getClientName(); // Get the original name of the file
            $uploadedFile->move(ROOTPATH . '/public/uploads', $originalName);


            return $this->response->setJSON(['filename' => $originalName]);
        } else {
            return $this->response->setJSON(['error' => 'Failed to upload image']);
        }
    }


    public function fetchAllImages()
    {
        $menu = new MenuModel();
        $imageUrls = $menu->select('image')->findAll();

        return $this->response->setJSON(['imageUrls' => $imageUrls]);
    }

    
}
