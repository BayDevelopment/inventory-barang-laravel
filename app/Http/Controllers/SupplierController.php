<?php

namespace App\Http\Controllers;

use App\Models\SupplierModel;

class SupplierController extends Controller
{
    public function index()
    {
        $D_Supplier = SupplierModel::all();
        $data = [
            'title' => 'Data Supplier',
            'navlink' => 'Data Supplier',
            'd_supplier' => $D_Supplier,
        ];

        return view('admin.supplier.page-data-supplier', $data);
    }
}
