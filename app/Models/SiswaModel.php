<?php

namespace App\Models;

use CodeIgniter\Model;

class SiswaModel extends Model
{
    protected $table = 'siswa';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama', 'alamat', 'email', 'nohp', 'status'];

    public function jointest()
    {
        return $this->db->table('siswa')->select('*')->join('kelas', 'kelas.id = siswa.idkelas')->get()->getResultArray();
    }
}
