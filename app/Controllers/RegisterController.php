<?php

namespace App\Controllers;

use CodeIgniter\Restful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\AccountModel;

class RegisterController extends ResourceController
{
    use ResponseTrait;

    public function register()
    {
        // Get the JSON data from the request
        $json = $this->request->getJSON();

        // Extract data from JSON
        $firstName = $json->firstName;
        $lastName = $json->lastName;
        $email = $json->email;
        $password = $json->password;

        // Validate input data (add your validation logic)

        // Example: Insert user data into the database using the AccountModel
        $accountModel = new AccountModel();

        // Hash the password before storing it (you might want to use a better hashing method)
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare data for insertion
        $userData = [
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'password' => $hashedPassword,
            // Add other fields if needed 
        ];

        // Insert data into the database
        $result = $accountModel->insert($userData);

        if ($result) {
            // Registration successful
            return $this->respond(['success' => true, 'message' => 'User registered successfully']);
        } else {
            // Registration failed
            return $this->respond(['success' => false, 'message' => 'Registration failed']);
        }
    }
}
