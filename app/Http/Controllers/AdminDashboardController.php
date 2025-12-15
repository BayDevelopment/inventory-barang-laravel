<?php

namespace App\Http\Controllers;

class AdminDashboardController extends Controller
{
    //
    public function index()
    {
        $data = [
            'title' => 'Dashboard | Inventory Barang',
        ];

        return view('admin.dashboard');
    }
}
