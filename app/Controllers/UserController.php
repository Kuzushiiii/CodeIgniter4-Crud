<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;

class UserController extends BaseController
{
    public function index()
    {
        return view('users/index');
    }

    public function store()
    {
        $username = $this->request->getPost('username');
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        if (!$username || !$email || !$password) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Semua field wajib diisi'
            ]);
        }

        $userModel = new UserModel();

        if ($userModel->where('email', $email)->first()) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Email sudah terdaftar'
            ]);
        }

        $userModel->insert([
            'username' => $username,
            'email'    => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ]);

        return $this->response->setJSON([
            'status' => true,
            'message' => 'User berhasil ditambahkan'
        ]);
    }

    public function create()
    {
        return view('users/create');
    }

    public function update($id)
    {
        $username = $this->request->getPost('username');
        $email    = $this->request->getPost('email');

        if (!$username || !$email) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Data tidak boleh kosong'
            ]);
        }

        $userModel = new UserModel();
        $userModel->update($id, [
            'username' => $username,
            'email'    => $email
        ]);

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Data berhasil diupdate'
        ]);
    }

    public function edit($id)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);

        if (!$user) {
            return redirect()->to('/users')->with('error', 'User tidak ditemukan');
        }

        return view('users/edit', [
            'user' => $user
        ]);
    }

    public function fetch()
    {
        $keyword = $this->request->getGet('keyword');

        $userModel = new UserModel();

        if ($keyword) {
            $users = $userModel
                ->like('username', $keyword)
                ->orLike('email', $keyword)
                ->findAll();
        } else {
            $users = $userModel->findAll();
        }

        return $this->response->setJSON($users);
    }


    public function delete($id)
    {
        $userModel = new UserModel();
        $userModel->delete($id);

        return $this->response->setJSON(['status' => true, 'message' => 'Data berhasil dihapus']);
    }
}
