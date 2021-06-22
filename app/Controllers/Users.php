<?php

namespace App\Controllers;

use App\Models\UsersModel;
use CodeIgniter\HTTP\Files\UploadedFile;
use CodeIgniter\Validation\Rules;

class Users extends BaseController
{
    protected $usersmodel;
    public function __construct()
    {
        $this->usersmodel = new UsersModel();
    }
    public function index()
    {
        $usernamesession = session()->get('username');
        // dd($usernamesession);
        $data = [
            'title' => 'Halaman Pendataan Users',
            'usersdata' => $this->usersmodel->where('username !=', $usernamesession)->findAll(),
            'validation' => \Config\Services::validation()
        ];
        return view('SAdmin/user', $data);
    }

    public function save()
    {
        // validasi setiap inputan
        if (!$this->validate([
            'foto' => 'max_size[foto,500]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]',
            'username' => 'required',
            'password' => 'required',
            'role' => 'required'
        ])) {

            return redirect()->to('/users')->withInput();
        };
        // mengolah gambar dan memindahkan filenya
        $filefoto = $this->request->getFile('foto');
        // cek apakah ada file foto yg diupload atau tidak
        // error 4 memandakan tidak ada file foto yg diupload
        if ($filefoto->getError() == 4) {
            // jika kosong maka isikan dengan nama default
            $namafoto = 'default.png';
        } else {
            // jika tidak kosong maka acak namanya dengan methode getRandomName bawaan CI dan pindahkan filenya
            $namafoto = $filefoto->getRandomName();
            $filefoto->move('img', $namafoto);
        }
        $username = $this->request->getVar('username');
        // hashing password
        $password = $this->request->getVar('password');
        $passwordhash = password_hash($password, PASSWORD_BCRYPT);
        // cek apakah username sudah terpakai atau belum
        $cekusername = $this->usersmodel->where('username', $username)->first();
        if (!$cekusername) {
            // menyimpan data dari form ke database
            $this->usersmodel->save([
                'foto' => $namafoto,
                'username' => $username,
                'password' => $passwordhash,
                'role' => $this->request->getVar('role'),
                'status' => 'Active'
            ]);
            session()->setFlashdata('pesan', 'Data berhasil disimpan!');
        } else {
            session()->setFlashdata('pesan', 'Username sudah ada!');
        }
        return redirect()->to('/users');
    }

    public function delete($id)
    {
        // delete gambar dari server
        $carinamafoto = $this->usersmodel->find($id);
        // tambahkan kondisi jika fotonya default file fotonya jgn dihapus
        if ($carinamafoto['foto'] != 'default.png') {
            unlink('img/' . $carinamafoto['foto']);
        }

        $this->usersmodel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus!');
        return redirect()->to('/users');
    }

    public function editsave()
    {
        // validasi setiap inputan
        if (!$this->validate([
            'editfoto' => 'max_size[editfoto,500]|is_image[editfoto]|mime_in[editfoto,image/jpg,image/jpeg,image/png]'
        ])) {
            return redirect()->to('/users')->withInput();
        };

        // menanggkap id secara manual
        $id = $this->request->getVar('id');

        // mengolah gambar dan memindahkan filenya
        $editfilefoto = $this->request->getFile('editfoto');
        // cek apakah ada file foto yg diupload atau tidak
        // error 4 memandakan tidak ada file foto yg diupload
        if ($editfilefoto->getError() == 4) {
            // jika kosong maka isikan dengan nama default
            $editnamafoto = $this->request->getVar('editfotolama');
        } else {
            // jika tidak kosong maka acak namanya dengan methode getRandomName bawaan CI dan pindahkan filenya
            $editnamafoto = $editfilefoto->getRandomName();
            $editfilefoto->move('img', $editnamafoto);
            // buat kondisi jika nama fotonya default maka jangan dihapus file defaultnya
            $carinamafotoedit = $this->usersmodel->find($id);
            // tambahkan kondisi jika fotonya default file fotonya jgn dihapus
            if ($carinamafotoedit['foto'] != 'default.png') {
                unlink('img/' . $this->request->getVar('editfotolama'));
            }
        }

        //mengecek apakah data role diisi atau tidak, dan jika tidak data akan sama
        if ($this->request->getVar('editrole') != '') {
            $editrole = $this->request->getVar('editrole');
        } else {
            $editrole = $this->request->getVar('rolesebelumnya');
        }

        //mengecek apakah data statua diisi atau tidak, dan jika tidak data akan sama
        if ($this->request->getVar('status') != '') {
            $status = $this->request->getVar('status');
        } else {
            $status = $this->request->getVar('statusebelumnya');
        }

        // dd($editrole);

        $password = $this->request->getVar('editpassword');
        // mengecek password ada sinya atau tidak
        if ($password != '') {
            // menyimpan data dari form ke database
            // hashing password
            $passwordhash = password_hash($password, PASSWORD_BCRYPT);
            $this->usersmodel->update($id, [
                'foto' => $editnamafoto,
                'password' => $passwordhash,
                'role' => $editrole,
                'status' => $status
            ]);
            session()->setFlashdata('pesan', 'Data berhasil diubah!');
        } else {
            $this->usersmodel->update($id, [
                'foto' => $editnamafoto,
                'role' => $editrole,
                'status' => $status
            ]);
            session()->setFlashdata('pesan', 'Data berhasil diubah!');
        }


        return redirect()->to('/users');
    }
}
