<?php

namespace App\Controllers;

use App\Models\ServersideSiswaModel;
use App\Models\SiswaModel;
use CodeIgniter\HTTP\Files\UploadedFile;
use CodeIgniter\Validation\Rules;
use Config\Services;

class Siswa extends BaseController
{
    protected $siswamodel;
    public function __construct()
    {
        $this->siswamodel = new SiswaModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Halaman Pendataan Siswa',
            'validation' => \Config\Services::validation()
        ];
        return view('Admin/siswa', $data);
    }

    public function siswaclientside()
    {
        $data = [
            'title' => 'Halaman Pendataan Siswa',
            'siswadata' => $this->siswamodel->jointest(),
            'validation' => \Config\Services::validation()
        ];
        return view('Admin/siswaclientside', $data);
    }

    // serverside
    public function listsiswa()
    {
        $request = Services::request();
        // memanggil model khusus untuk serverside
        $siswa = new ServersideSiswaModel($request);


        if ($request->getMethod(true) == 'POST') {
            $lists = $siswa->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {


                $tombol = "<div class=\"btn-group\">
                <button type=\"button\" class=\"btn btn-warning btn-icon-split btn-sm mr-1\" id=\"editdatabtn\" data-toggle=\"modal\" data-editid=\"$list->id\" data-editnama=\"$list->nama\" data-editalamat=\"$list->alamat\" data-editemail=\"$list->email\" data-editnohp=\"$list->nohp\" data-editstatus=\"$list->status\" data-target=\"#editdata\">
                    <span class=\"icon text-white\">
                        <i class=\"fas fa-user-edit\"></i>
                    </span>
                    <span class=\"text\">Ubah</span>
                </button>
                <form action=\"/siswa/$list->id\" method=\"post\">
                <?= csrf_field(); ?>
                <input type=\"text\" name=\"_method\" value=\"DELETE\" hidden>
                <button id=\"hapus\" type=\"submit\" class=\"btn btn-danger btn-icon-split btn-sm\" onclick=\"return confirm('Apakah anda yakin ingin menghapus data ini?');\">
                    <span class=\"icon text-white\">
                        <i class=\"fas fa-trash-alt\"></i>
                    </span>
                    <span class=\"text\">Hapus</span>
                </button>
                </form>
              </div>";


                $no++;
                $row = [];
                // disini bagian untuk melooping data, pastikan sesuai dengan nama coloumnya
                $row[] = $no;
                $row[] = $list->nama;
                $row[] = $list->alamat;
                $row[] = $list->email;
                $row[] = $list->nohp;
                $row[] = $list->status;
                $row[] = $list->kelas;
                $row[] = $list->pembimbing;
                $row[] = $tombol;
                $data[] = $row;
            }

            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $siswa->count_all(),
                "recordsFiltered" => $siswa->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }


    public function save()
    {
        // validasi setiap inputan
        if (!$this->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'email' => 'required|valid_email',
            'nohp' => 'required|numeric'
        ])) {

            return redirect()->to('/siswa')->withInput();
        };
        // menyimpan data dari form ke database
        $this->siswamodel->save([
            'nama' => $this->request->getVar('nama'),
            'alamat' => $this->request->getVar('alamat'),
            'email' => $this->request->getVar('email'),
            'nohp' => $this->request->getVar('nohp'),
            'status' => 'Active'
        ]);
        session()->setFlashdata('pesan', 'Data berhasil disimpan!');
        return redirect()->to('/siswa');
    }

    public function delete($id)
    {
        $this->siswamodel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus!');
        return redirect()->to('/siswa');
    }

    public function editsave()
    {
        // validasi setiap inputan
        if (!$this->validate([
            'editnama' => 'required',
            'editalamat' => 'required',
            'editemail' => 'required|valid_email',
            'editnohp' => 'required|numeric'
        ])) {

            return redirect()->to('/siswa')->withInput();
        };
        // menanggkap id secara manual
        $id = $this->request->getVar('id');
        //mengecek apakah data statua diisi atau tidak, dan jika tidak data akan sama
        if ($this->request->getVar('status') != '') {
            $status = $this->request->getVar('status');
        } else {
            $status = $this->request->getVar('statusebelumnya');
        }
        // menyimpan data dari form ke database
        $this->siswamodel->update($id, [
            'nama' => $this->request->getVar('editnama'),
            'alamat' => $this->request->getVar('editalamat'),
            'email' => $this->request->getVar('editemail'),
            'nohp' => $this->request->getVar('editnohp'),
            'status' => $status
        ]);
        session()->setFlashdata('pesan', 'Data berhasil diubah!');
        return redirect()->to('/siswa');
    }
}
