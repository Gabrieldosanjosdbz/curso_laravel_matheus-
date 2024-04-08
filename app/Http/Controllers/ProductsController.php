<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index() {

        $busca = Request('surch');
    
        return view('products', ['busca' => $busca]);
    }

    public function teste($id = null) {

    return view('product', ['id' => $id]);
    
}
}
