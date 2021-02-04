<?php

namespace App\Http\Controllers\Backend;

use Auth;
use App\Model\Unit;
use App\Model\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UnitController extends Controller
{
    public function view(){

        $totalQuantity = Product::where('status',1)->sum('quantity');

        $allData = Unit::all();
        return view('backend.unit.view-unit',compact('allData','totalQuantity'));
    }
    public function add(){

        $totalQuantity = Product::where('status',1)->sum('quantity');

        return view('backend.unit.add-unit',compact('totalQuantity'));
    }
    public function store(Request $request){
        $unit = new Unit();
        $unit->name = $request->name;
        $unit->created_by = Auth::user()->id;
        $unit->save();

        return redirect()->route('units.view')->with('success','Data Save SuccessFully');
    }
    public function edit($id){

        $totalQuantity = Product::where('status',1)->sum('quantity');

        $editData = Unit::find($id);
        return view('backend.unit.edit-unit',compact('editData','totalQuantity'));
    }
    public function update(Request $request ,$id){
        $unit = Unit::find($id);
        $unit->name = $request->name;
        $unit->updated_by = Auth::user()->id;
        $unit->save();

        return redirect()->route('units.view')->with('success','Data Updated SuccessFully');

    }
    public function delete($id){
        $unit = Unit::find($id);
        $unit->delete();
        return redirect()->route('units.view')->with('success','Data Delete SuccessFully');
    }
}
