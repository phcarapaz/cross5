<?php
namespace App\Controllers\Api;

use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;

class Users extends ResourceController {
    protected $modelName = 'App\Models\UserModel';
    protected $format = 'json';

    public function create() {
        //$data = $this->request->getJSON();
        //$data->password = password_hash($data->password, PASSWORD_DEFAULT);
       // $this->model->save($data);
       // return $this->respondCreated($data);

        $data = $this->request->getJSON(true); // หรือ getPost() ถ้าใช้ form-urlencoded

        if (!$data || !isset($data['name'], $data['email'], $data['password'])) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Invalid input']);
        }

        $model = new UserModel();
        $model->insert($data);
        return $this->response->setStatusCode(201)->setJSON(['message' => 'User created']);
    }

    public function index() {
        return $this->respond($this->model->findAll());
    }

    public function show($id = null) {
        $user = $this->model->find($id);
        return $user ? $this->respond($user) : $this->failNotFound();
    }

    public function update($id = null) {
        $data = $this->request->getJSON();
        if (isset($data->password)) {
            $data->password = password_hash($data->password, PASSWORD_DEFAULT);
        }
        $this->model->update($id, $data);
        return $this->respond($data);
    }

    public function delete($id = null) {
        $this->model->delete($id);
        return $this->respondDeleted(['id' => $id]);
    }
}
