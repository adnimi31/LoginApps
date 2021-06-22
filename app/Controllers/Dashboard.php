<?php

namespace App\Controllers;

class Dashboard extends BaseController
{

    public function dashboardsadmin()
    {
        session();
        $data = [
            'title' => 'Dashboard Super Admin'
        ];
        return view('SAdmin/index', $data);
    }

    public function dashboardadmin()
    {
        session();
        $data = [
            'title' => 'Dashboard Admin'
        ];
        return view('Admin/index', $data);
    }
}
