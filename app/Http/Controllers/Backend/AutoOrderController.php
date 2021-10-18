<?php

namespace App\Http\Controllers\Backend;

use App\Model\Product;
use App\Model\Purchase;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AutoOrderController extends Controller
{
    public function view(){
        $totalQuantity = Product::where('status',1)->sum('quantity');
        $allData = Product::all();
        return view('backend.autoorder.view-autoorder',compact('allData','totalQuantity'));
    }
}
