<?php

namespace App\Controllers;

use CodeIgniter\Restful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\AccountModel;

class LoginController extends ResourceController
{
    use ResponseTrait;

    public function login()
    {
        // Get the JSON data from the request
        $json = $this->request->getJSON();

        // Extract data from JSON
        $email = $json->email;
        $password = $json->password;

        // Validate input data (add your validation logic)

        // Example: Check user credentials against the database using the AccountModel
        $accountModel = new AccountModel();
        $user = $accountModel->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {
            // Login successful
            // You may want to generate a token or session here
            return $this->respond(['success' => true, 'message' => 'Login successful']);
        } else {
            // Login failed
            return $this->respond(['success' => false, 'message' => 'Invalid email or password']);
        }
    }
}
