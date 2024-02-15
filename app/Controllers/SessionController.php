<?php

namespace App\Controllers;


use CodeIgniter\Restful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\SessionModel;

class SessionController extends ResourceController
{
    use ResponseTrait;
    public function index()
    {
        //
    }

    public function newSession()
    {
        $json = $this->request->getJSON();

        $data = [
            // 'user_id' => $json->user_id, // Assuming you have the user_id available
            // 'start_time' => $json->start_time,
            // 'end_time' => $json->end_time,
            'status' => $json->status,
            'opening_cash' =>  $json->opening_cash,
        ];

        $session = new SessionModel();
        $r = $session->save($data);

        if ($r) {
            // If the save operation was successful, return the inserted ID
            return $this->respond(['id' => $session->getInsertID()], 200);
        } else {
            // If the save operation failed, return an error response
            return $this->fail($session->errors(), 400);
        }
    }

    public function getSessions()
    {
        // Assuming you want to retrieve all sessions
        $sessionModel = new SessionModel();
        $sessions = $sessionModel->findAll();

        // Check if sessions were found
        if ($sessions) {
            return $this->respond($sessions, 200);
        } else {
            return $this->respond(['message' => 'No sessions found.'], 404);
        }
    }
}
