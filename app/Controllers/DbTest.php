<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Database;

class DbTest extends Controller
{
    public function index()
    {
        $db = Database::connect();
        return 'Koneksi database berhasil!';
    }
}
