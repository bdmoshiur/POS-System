<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Customer;
use Auth;

class CustomerController extends Controller
{
    public function view(){
        $allData = Customer::all();
        return view('backend.customer.view-customer',compact('allData'));
    }
    public function add(){
        return view('backend.customer.add-customer');
    }
    public function store(Request $request){
        $customer = new Customer();
        $customer->name = $request->name;
        $customer->mobile_no = $request->mobile_no;
        $customer->email = $request->email;
        $customer->address = $request->address;
        $customer->created_by = Auth::user()->id;
        $customer->save();

        return redirect()->route('customers.view')->with('success','Data Save SuccessFully');
    }
    public function edit($id){
        $editData = Customer::find($id);
        return view('backend.customer.edit-customer',compact('editData'));
    }
    public function update(Request $request ,$id){
        $customer = Customer::find($id);
        $customer->name = $request->name;
        $customer->mobile_no = $request->mobile_no;
        $customer->email = $request->email;
        $customer->address = $request->address;
        $customer->updated_by = Auth::user()->id;
        $customer->save();

        return redirect()->route('customers.view')->with('success','Data Updated SuccessFully');

    }
    public function delete($id){
        $customer = Customer::find($id);
        $customer->delete();
        return redirect()->route('customers.view')->with('success','Data Delete SuccessFully');
    }
}
