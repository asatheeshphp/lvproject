<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        //get the products list from the product model using one to one connection
        $products = Product::all();
        //dd($products);exit;
        return view('products.index', compact('products'));
    }
}
