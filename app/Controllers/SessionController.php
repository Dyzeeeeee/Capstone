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

    public function endSession($id)
    {
        // Validate $id (ensure it's a valid session ID)

        // Assuming you have the 'status' and 'end_time' in the request JSON
        $json = $this->request->getJSON();

        $timezone = new \DateTimeZone('Asia/Manila'); // Replace with your actual time zone
        $now = new \DateTime('now', $timezone);

        $data = [
            'status' => $json->status, // Set the status to 'closed'
            'end_time' => $now->format('Y-m-d H:i:s'),
        ];

        $sessionModel = new SessionModel();
        $session = $sessionModel->find($id);

        if (!$session) {
            return $this->fail('Session not found', 404);
        }

        // Update the session with the provided data
        $r = $sessionModel->update($id, $data);

        if ($r) {
            return $this->respond(['message' => 'Session ended successfully'], 200);
        } else {
            return $this->fail($sessionModel->errors(), 400);
        }
    }
}
