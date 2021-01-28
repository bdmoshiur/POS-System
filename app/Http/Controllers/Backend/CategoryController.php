<?php

namespace App\Http\Controllers\Backend;

use Auth;
use App\Model\Product;
use App\Model\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class CategoryController extends Controller
{
    public function view(){
        $lowStoc = 5;
        $totalQuantity = Product::where('status',1)->sum('quantity');
        
        $allData = Category::all();
        return view('backend.category.view-category',compact('allData','totalQuantity','lowStoc'));
    }
    public function add(){
        $lowStoc = 5;
        $totalQuantity = Product::where('status',1)->sum('quantity');
        
        return view('backend.category.add-category',compact('totalQuantity','lowStoc'));
    }
    public function store(Request $request){
        $category = new Category();
        $category->name = $request->name;
        $category->created_by = Auth::user()->id;
        $category->save();

        return redirect()->route('categories.view')->with('success','Data Save SuccessFully');
    }
    public function edit($id){
        $lowStoc = 5;
        $totalQuantity = Product::where('status',1)->sum('quantity');

        $editData = Category::find($id);
        return view('backend.category.edit-category',compact('editData','totalQuantity','lowStoc'));
    }
    public function update(Request $request ,$id){
        $category = Category::find($id);
        $category->name = $request->name;
        $category->updated_by = Auth::user()->id;
        $category->save();

        return redirect()->route('categories.view')->with('success','Data Updated SuccessFully');

    }
    public function delete($id){
        $category = Category::find($id);
        $category->delete();
        return redirect()->route('categories.view')->with('success','Data Delete SuccessFully');
    }
}
