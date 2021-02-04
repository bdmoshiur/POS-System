<?php

namespace App\Http\Controllers\Backend;

use App\Model\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Purchase;

class AutoOrderController extends Controller
{
    public function view(){
        $totalQuantity = Product::where('status',1)->sum('quantity');

        $allData = Purchase::all();
        return view('backend.autoorder.view-autoorder',compact('allData','totalQuantity'));
    }





}
