<?php

namespace App\Http\Controllers;

use App\Model\Customer;
use App\Model\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $lowStoc = 5;
        $totalQuantity = Product::where('status',1)->sum('quantity');

        $customers = Customer::where('status','1')->get()->count();
        return view('backend.layouts.home',compact('customers','totalQuantity','lowStoc'));
    }
}
