<?php

namespace App\Controllers\Api;
use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Libraries\JwtHandler;
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

    $decoded = $token ? $jwt->validate($token) : false;

    if ($decoded) {
        // สมมติเรามี name ใน token ด้วย หรือจะดึงจาก DB ก็ได้
        return $response->setJSON([
            'status' => true,
            'data' => [
                'email' => $decoded['email'],
                'name'  => $decoded['name'] ?? 'User' // fallback ถ้าไม่มีชื่อ
            ]
        ]);
    } else {
        return $response->setJSON([
            'status' => false,
            'message' => 'Unauthorized'
        ]);
    }
}
}
