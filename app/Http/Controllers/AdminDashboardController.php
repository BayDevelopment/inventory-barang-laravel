<?php

namespace App\Http\Controllers;

class AdminDashboardController extends Controller
{
    //
    public function index()
    {
        $data = [
            'title' => 'Dashboard | Inventory Barang',
            'navlink' => 'Dashboard',
        ];

        return view('admin.dashboard', $data);
    }
}
