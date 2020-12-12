<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Product;
use App\Model\Purchase;
use App\Model\Supplier;
use App\Model\Unit;
use App\Model\Category;
use Auth;

class PurchaseController extends Controller
{
    public function view(){
        $allData = Purchase::orderBy('date','desc')->orderBy('id','desc')->get();
        return view('backend.purchase.view-purchase',compact('allData'));
    }
    public function add(){
        $data['suppliers'] = Supplier::all();
        $data['categories'] = Category::all();
        $data['units'] = Unit::all();
        return view('backend.purchase.add-purchase',$data);
    }
    public function store(Request $request){
        $product = new Purchase();
        $product->supplier_id = $request->supplier_id;
        $product->category_id = $request->category_id;
        $product->unit_id = $request->unit_id;
        $product->name = $request->name;
        $product->quantity = '0';
        $product->created_by = Auth::user()->id;
        $product->save();

        return redirect()->route('products.view')->with('success','Data Save SuccessFully');
    }
    public function edit($id){
        $data['editData'] = Purchase::find($id);
        $data['suppliers'] = Supplier::all();
        $data['categories'] = Category::all();
        $data['units'] = Unit::all();
        return view('backend.product.edit-product',$data);
    }
    public function update(Request $request ,$id){
        $product = Purchase::find($id);
        $product->supplier_id = $request->supplier_id;
        $product->category_id = $request->category_id;
        $product->unit_id = $request->unit_id;
        $product->name = $request->name;
        $product->quantity = '0';
        $product->created_by = Auth::user()->id;
        $product->save();

        return redirect()->route('products.view')->with('success','Data Updated SuccessFully');

    }
    public function delete($id){
        $product = Purchase::find($id);
        $product->delete();
        return redirect()->route('products.view')->with('success','Data Delete SuccessFully');
    }
}
