<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;

class UserController extends BaseController
{
    // Menampilkan halaman daftar user
    public function index()
    {
        return view('users/index'); //menampilkan view daftar user dari folder users
    }

    // Menyimpan user baru
    public function store()
    {
        //mengambil data dari form
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

    // Menampilkan form untuk membuat user baru
    public function create()
    {
        return view('users/create');
    }

    // Memperbarui data user
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

    // Menampilkan form edit user
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

    // Mengambil data user untuk AJAX
    public function fetch()
    {
        $keyword = $this->request->getGet('keyword');//mengambil parameter keyword dari AJAX

        $userModel = new UserModel();

        //jika ada keyword, cari user berdasarkan username atau email
        if ($keyword !== null && $keyword !== '') {
            $users = $userModel->search($keyword); //panggil method search di UserModel jika ada keyword
        } else {
            $users = $userModel->findAll();//ambil semua user jika tidak ada keyword
        }

        return $this->response->setJSON(array_values($users));
    }

    // Menghapus user
    public function delete($id)
    {
        $userModel = new UserModel();
        $userModel->delete($id);

        return $this->response->setJSON(['status' => true, 'message' => 'Data berhasil dihapus']);
    }
}
