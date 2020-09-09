<?php

namespace App\Http\Controllers\Stripe;

use App\Product;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;
use App\Http\Controllers\Controller;



class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('product.index', compact('products'));
    }
}
