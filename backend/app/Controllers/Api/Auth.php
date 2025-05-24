<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\UserModel;
use JwtHandler;

class Auth extends Controller
{
    public function login()
    {
        $request = service('request');
        $response = service('response');

        if ($request->getMethod() !== 'post') {
            return $response->setStatusCode(405)->setJSON([
                'status' => false,
                'message' => 'Method Not Allowed',
            ]);
        }

        $data = $request->getJSON();

        if (!isset($data->email) || !isset($data->password)) {
            return $response->setJSON([
                'status' => false,
                'message' => 'Email and password are required'
            ]);
        }

        $userModel = new UserModel();
        $user = $userModel->check_login($data->email, $data->password);

        if ($user) {
            $jwt = new JwtHandler();
            $token = $jwt->encode([
                'id' => $user['id'],
                'email' => $user['email']
            ]);
            return $response->setJSON([
                'status' => true,
                'token' => $token
            ]);
        } else {
            return $response->setJSON([
                'status' => false,
                'message' => 'Invalid credentials'
            ]);
        }
    }

    public function protected_route()
    {
        $request = service('request');
        $response = service('response');

        $jwt = new JwtHandler();
        $authHeader = $request->getHeaderLine('Authorization');
        $token = null;

        if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        }

        if ($token && $jwt->validate($token)) {
            return $response->setJSON([
                'status' => true,
                'data' => 'Access Granted'
            ]);
        } else {
            return $response->setJSON([
                'status' => false,
                'message' => 'Unauthorized'
            ]);
        }
    }
}
