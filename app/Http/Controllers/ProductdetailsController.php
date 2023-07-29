<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductdetailsController extends Controller
{
    public function show($product_id)
    {
        //get the products list from the product model using one to one connection
        $product_details = Product::find($product_id);
        //dd($product_details);exit;
        return view('productdetails.index', compact('product_details'));
    }


    
}
