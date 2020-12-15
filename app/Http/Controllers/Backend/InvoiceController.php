<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Product;
use App\Model\Purchase;
use App\Model\Category;
use App\Model\Customer;
use Auth;
use DB;
use App\Model\Invoice;
use App\Model\InvoiceDetail;
use App\Model\Payment;
use App\Model\PaymentDetail;

class InvoiceController extends Controller
{
    public function view(){
        $allData = Invoice::orderBy('date','desc')->orderBy('id','desc')->get();
        return view('backend.invoice.view-invoice',compact('allData'));
    }
    public function add(){
        $data['categories'] = Category::all();
        $invoice_data = Invoice::orderBy('id','DESC')->first();
        if($invoice_data == null){
            $firstReg = 0;
            $data['invoice_no'] = $firstReg + 1;
        }else{
            $invoice_data = Invoice::orderBy('id','DESC')->first()->invoice_no;
            $data['invoice_no'] = $invoice_data + 1;
        }
        $data['customers'] = Customer::all();
        return view('backend.invoice.add-invoice',$data);
    }
    public function store(Request $request){
        if($request->category_id == null){
            return redirect()->back()->with('error','Sorry! You do not select any item.');
        }else{
            $count_category = count($request->category_id);
            for($i =0; $i < $count_category; $i++){
                $purchase = new Purchase();
                $purchase->date = date('Y-m-d',strtotime($request->date[$i]));
                $purchase->purchase_no = $request->purchase_no[$i];
                $purchase->supplier_id = $request->supplier_id[$i];
                $purchase->category_id = $request->category_id[$i];
                $purchase->product_id = $request->product_id[$i];
                $purchase->buying_qty = $request->buying_qty[$i];
                $purchase->unit_price = $request->unit_price[$i];
                $purchase->buying_price = $request->buying_price[$i];
                $purchase->description = $request->description[$i];
                $purchase->created_by = Auth::user()->id;
                $purchase->status = '0';
                $purchase->save();
            }
        }
        return redirect()->route('purchase.view')->with('success','Data Save SuccessFully');
    }
    public function delete($id){
        $purchase = Purchase::find($id);
        $purchase->delete();
        return redirect()->route('purchase.view')->with('success','Data Delete SuccessFully');
    }

    public function pendingList(){
        $allData = Purchase::orderBy('date','desc')->orderBy('id','desc')->where('status','0')->get();
        return view('backend.purchase.view-pending-list',compact('allData'));
    }

    public function approve($id){
        $purchase = Purchase::find($id);
        $product = Product::where('id',$purchase->product_id)->first();
        $purchase_qty = ((float)$purchase->buying_qty)+((float)$product->quantity);
        $product->quantity = $purchase_qty;
        if($product->save()){
            DB::table('purchases')
            ->where('id',$id)
            ->update(['status'=> 1]);
        }
        return redirect()->route('purchase.pending.list')->with('success','Data Approved SuccessFully');

    }

}
