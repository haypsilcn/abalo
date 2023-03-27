<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AbTestData;

class AbTestDataController extends Controller
{
    public function index() {
        $products = (new AbTestData())->ab_testdata_all();

        return view('testdata', [
            "products" => $products
        ]);
    }
}
