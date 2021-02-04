<?php

namespace App\Http\Controllers\Backend;

use Auth;
use App\Model\Product;
use App\Model\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SupplierController extends Controller
{
    public function view(){

        $totalQuantity = Product::where('status',1)->sum('quantity');

        $allData = Supplier::all();
        return view('backend.supplier.view-supplier',compact('allData','totalQuantity'));
    }
    public function add(){

        $totalQuantity = Product::where('status',1)->sum('quantity');

        return view('backend.supplier.add-supplier',compact('totalQuantity'));
    }
    public function store(Request $request){
        $supplier = new Supplier();
        $supplier->name = $request->name;
        $supplier->mobile_no = $request->mobile_no;
        $supplier->email = $request->email;
        $supplier->address = $request->address;
        $supplier->created_by = Auth::user()->id;
        $supplier->save();

        return redirect()->route('suppliers.view')->with('success','Data Save SuccessFully');
    }
    public function edit($id){

        $totalQuantity = Product::where('status',1)->sum('quantity');

        $editData = Supplier::find($id);
        return view('backend.supplier.edit-supplier',compact('editData','totalQuantity'));
    }

    public function update(Request $request ,$id){
        $supplier = Supplier::find($id);
        $supplier->name = $request->name;
        $supplier->mobile_no = $request->mobile_no;
        $supplier->email = $request->email;
        $supplier->address = $request->address;
        $supplier->updated_by = Auth::user()->id;
        $supplier->save();

        return redirect()->route('suppliers.view')->with('success','Data Updated SuccessFully');

    }
    public function delete($id){
        $supplier = Supplier::find($id);
        $supplier->delete();
        return redirect()->route('suppliers.view')->with('success','Data Delete SuccessFully');
    }
}
