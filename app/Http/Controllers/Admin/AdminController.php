<?php

namespace App\Http\Controllers\Admin;

use App\Imports\FoodsImport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    public function index()
    {

        return view('admin.index');
    }

    public function importExcel()
    {

        $array = Excel::import(new FoodsImport, 'storage/1.xlsx');

        return $array;
    }

}
