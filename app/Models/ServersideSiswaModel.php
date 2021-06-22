<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class ServersideSiswaModel extends Model
{


    // menentukan coloum apa saya yg bisa di order nantinya(diurutkan)
    protected $column_order = array(null, 'nama', null, null, null, null, null, null, null);
    //menentukan ketika kita search coloum apa saja yg bisa di searc
    //*catatan penting : ketika menggunakan join saya hanya bisa search melalui colom di tabel pertama
    protected $column_search = array('nama', 'alamat', 'email', 'nohp');
    //mengurutkan berdasarkan data terbaru
    protected $order = array('siswa.id' => 'desc');
    protected $request;
    protected $db;
    protected $dt;

    function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
        // disi tempat untuk query nya, entah itu 1 tabel atau join (detail query bisa di cek di dokumentasi ci4 query builder)
        $this->dt = $this->db->table('siswa')->join('kelas', 'kelas.id = siswa.idkelas');
    }

    private function _get_datatables_query()
    {
        $i = 0;
        foreach ($this->column_search as $item) {
            if ($this->request->getPost('search')['value']) {
                if ($i === 0) {
                    $this->dt->groupStart();
                    $this->dt->like($item, $this->request->getPost('search')['value']);
                } else {
                    $this->dt->orLike($item, $this->request->getPost('search')['value']);
                }
                if (count($this->column_search) - 1 == $i)
                    $this->dt->groupEnd();
            }
            $i++;
        }

        if ($this->request->getPost('order')) {
            $this->dt->orderBy($this->column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->dt->orderBy(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        return $this->dt->countAllResults();
    }

    public function count_all()
    {
        $tbl_storage = $this->db->table('siswa')->join('kelas', 'kelas.id = siswa.idkelas');
        return $tbl_storage->countAllResults();
    }
}
