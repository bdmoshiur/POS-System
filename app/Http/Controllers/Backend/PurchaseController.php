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
use DB;
use PDF;
use Mail;

class PurchaseController extends Controller
{
    public function view(){

        $totalQuantity = Product::where('status',1)->sum('quantity');

        $allData = Purchase::orderBy('date','desc')->orderBy('id','desc')->get();
        return view('backend.purchase.view-purchase',compact('allData','totalQuantity'));
    }
    public function add(){

        $data['totalQuantity'] = Product::where('status',1)->sum('quantity');

        $data['suppliers'] = Supplier::all();
        $data['categories'] = Category::all();
        $data['units'] = Unit::all();
        $data['date'] = date('Y-m-d');
        return view('backend.purchase.add-purchase',$data);
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


    public function edit($id){
        $data['totalQuantity'] = Product::where('status',1)->sum('quantity');

        $data['suppliers'] = Supplier::find($id);
        $data['categories'] = Category::find($id);
        $data['units'] = Unit::find($id);
        $data['date'] = date('Y-m-d');
        $data['product'] = Product::find($id);
        $data['purchase'] = Purchase::find($id);
        return view('backend.purchase.edit-purchase',$data);
    }

    public function update(Request $request,$id){
        if($request->category_id == null){
            return redirect()->back()->with('error','Sorry! You do not select any item.');
        }else{
                $purchase = Purchase::find($id);
                $purchase->date = date('Y-m-d',strtotime($request->date));
                $purchase->purchase_no = $request->purchase_no;
                // $purchase->email = $request->email;
                $purchase->supplier_id = $request->supplier_id;
                $purchase->category_id = $request->category_id;
                $purchase->product_id = $request->product_id;
                $purchase->buying_qty = $request->buying_qty;
                $purchase->unit_price = $request->unit_price;
                $purchase->buying_price = $request->buying_price;
                $purchase->description = $request->description;
                $purchase->created_by = Auth::user()->id;
                $purchase->status = '0';
                $purchase->save();

                $data = array(
                'email' => $request->email,
                'buying_qty' => $request->buying_qty,
                'unit_price' => $request->unit_price,
                'buying_price' => $request->buying_price,
                'description' => $request->description,

                );

                Mail::send('backend.emails.contact', $data, function($message) use($data) {
                    $message->from('moshiurcse888@gmail.com','Test email for POS system with WUB');
                    $message->to($data['email']);
                    $message->subject('Amader aro kisu Product lagbe');
                });



        }
        return redirect()->route('purchase.pending.list')->with('success','Data Save SuccessFully');
    }







    public function delete($id){
        $purchase = Purchase::find($id);
        $purchase->delete();
        return redirect()->route('purchase.view')->with('success','Data Delete SuccessFully');
    }

    public function pendingList(){

        $totalQuantity = Product::where('status',1)->sum('quantity');

        $allData = Purchase::orderBy('date','desc')->orderBy('id','desc')->where('status','0')->get();
        return view('backend.purchase.view-pending-list',compact('allData','totalQuantity'));
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

    public function purchaseReport(){

        $totalQuantity = Product::where('status',1)->sum('quantity');

        return view('backend.purchase.daily-purchase-report',compact('totalQuantity'));
    }

    public function purchaseReportPdf(Request $request){
        $sdate = date('Y-m-d',strtotime($request->start_date));
        $edate = date('Y-m-d',strtotime($request->end_date));
        $data['allData'] = Purchase::whereBetween('date',[$sdate,$edate])->where('status','1')->orderBy('supplier_id')->orderBy('category_id')->orderBy('product_id')->get();
        $data['start_date'] = date('Y-m-d',strtotime($request->start_date));
        $data['end_date'] = date('Y-m-d',strtotime($request->end_date));
        $pdf = PDF::loadView('backend.pdf.daily-purchase-report-pdf', $data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');
        return $pdf->stream('document.pdf');

    }



}
