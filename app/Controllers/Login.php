<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Login extends BaseController
{
    protected $usersmodel;
    public function __construct()
    {
        $this->usersmodel = new UsersModel();
    }

    public function index()
    {
        $session = session();

        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $data = $this->usersmodel->where('username', $username)->first();
        // mengecek username sudah ada atau belum
        if ($data) {
            // mengecek status active users
            if ($data['status'] == 'Active') {
                $pass = $data['password'];
                $verify_pass = password_verify($password, $pass);
                //menverifikasi apakah password hash betul atau tidak
                if ($verify_pass) {
                    // setelah semua paramater terlewati maka buat session
                    $ses_data = [
                        'foto'       => $data['foto'],
                        'username'       => $data['username'],
                        'role'       => $data['role'],
                        'logged_in'     => TRUE
                    ];
                    $session->set($ses_data);
                    // me redirect sesuai dengan hak aksesnya
                    if ($session->role == 'SAdmin') {
                        return redirect()->to('/dashboardsadmin');
                    } else {
                        return redirect()->to('/dashboardadmin');
                    }
                } else {
                    $session->setFlashdata('pesan', 'Password salah!');
                    return redirect()->to('/');
                }
            } else {
                $session->setFlashdata('pesan', 'Status anda Non Active, Silahkan hubungi Administrator untuk lebih lanjut!');
                return redirect()->to('/');
            }
        } else {
            $session->setFlashdata('pesan', 'Username tidak ditemukan!');
            return redirect()->to('/');
        }
    }


    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/');
    }
}
