<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Product;
use App\Model\Category;
use App\Model\Customer;
use Auth;
use PDF;
use DB;
use App\Model\Invoice;
use App\Model\InvoiceDetail;
use App\Model\Payment;
use App\Model\PaymentDetail;

class InvoiceController extends Controller
{
    public function view(){
        $lowStoc = 5;
        $totalQuantity = Product::where('status',1)->sum('quantity');

        $allData = Invoice::orderBy('date','desc')->orderBy('id','desc')->where('status','1')->get();
        return view('backend.invoice.view-invoice',compact('allData','totalQuantity','lowStoc'));
    }
    public function add(){
        $data['lowStoc'] = 5;
        $data['totalQuantity'] = Product::where('status',1)->sum('quantity');
        
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
        $data['date'] = date('Y-m-d');
        return view('backend.invoice.add-invoice',$data);
    }
    public function store(Request $request){
        if($request->category_id == null){
            return redirect()->back()->with('error','Sorry! You do not select any Data.');
        }else{
            if($request->paid_amount > $request->estimated_amount){
                return redirect()->back()->with('error','Sorry! Paid amount is maximum then total price.');
            }else{
                $invoice = new Invoice();
                $invoice->invoice_no = $request->invoice_no;
                $invoice->date = date('Y-m-d',strtotime($request->date));
                $invoice->description = $request->description;
                $invoice->status = '0';
                $invoice->created_by = Auth::user()->id;

                DB::transaction(function () use($request,$invoice) {
                    if($invoice->save()){
                        $count_category = count($request->category_id);
                        for($i = 0; $i < $count_category; $i++){
                            $invoice_details = new InvoiceDetail();
                            $invoice_details->date = date('Y-m-d',strtotime($request->date));
                            $invoice_details->invoice_id = $invoice->id;
                            $invoice_details->category_id = $request->category_id[$i];
                            $invoice_details->product_id = $request->product_id[$i];
                            $invoice_details->selling_qty = $request->selling_qty[$i];
                            $invoice_details->unit_price = $request->unit_price[$i];
                            $invoice_details->selling_price = $request->selling_price[$i];
                            $invoice_details->status = '0';
                            $invoice_details->save();
                        }
                        if($request->customer_id == '0'){
                            $customer = new Customer();
                            $customer->name = $request->name;
                            $customer->mobile_no = $request->mobile_no;
                            $customer->address = $request->address;
                            $customer->save();
                            $customer_id = $customer->id;
                        }else{
                            $customer_id = $request->customer_id;
                        }
                        $payment = new Payment();
                        $payment_details = new PaymentDetail();
                        $payment->invoice_id = $invoice->id;
                        $payment->customer_id = $customer_id;
                        $payment->paid_status = $request->paid_status;
                        $payment->paid_amount = $request->paid_amount;
                        $payment->discount_amount = $request->discount_amount;
                        $payment->total_amount = $request->estimated_amount;
                        if($request->paid_status == "full_paid"){
                            $payment->paid_amount = $request->estimated_amount;
                            $payment->due_amount = '0';
                            $payment_details->current_paid_amount = $request->estimated_amount;
                        }elseif($request->paid_status == "full_due"){
                            $payment->paid_amount = '0';
                            $payment->due_amount = $request->estimated_amount;
                            $payment_details->current_paid_amount = '0';
                        }elseif($request->paid_status == "partial_paid"){
                            $payment->paid_amount = $request->paid_amount;
                            $payment->due_amount = $request->estimated_amount-$request->paid_amount;
                            $payment_details->current_paid_amount = $request->paid_amount;
                        }

                        $payment->save();
                        $payment_details->invoice_id = $invoice->id;
                        $payment_details->date = date('Y-m-d',strtotime($request->date));
                        $payment_details->save();
                    }
                });
            }
        }
        return redirect()->route('invoice.pending.list')->with('success','Data Save SuccessFully');
    }
    public function delete($id){
        $invoice = Invoice::find($id);
        $invoice->delete();
            InvoiceDetail::where('invoice_id',$invoice->id)->delete();
            Payment::where('invoice_id',$invoice->id)->delete();
            PaymentDetail::where('invoice_id',$invoice->id)->delete();
        return redirect()->route('invoice.pending.list')->with('success','Data Delete SuccessFully');
    }

    public function pendingList(){
        $lowStoc = 5;
        $totalQuantity = Product::where('status',1)->sum('quantity');

        $allData = Invoice::orderBy('date','desc')->orderBy('id','desc')->where('status','0')->get();
        return view('backend.invoice.pending-invoice',compact('allData','totalQuantity','lowStoc'));
    }

    public function approve($id){
        $lowStoc = 5;
        $totalQuantity = Product::where('status',1)->sum('quantity');

        $invoice = Invoice::with('invoice_details')->find($id);
        return view('backend.invoice.invoice-approve',compact('invoice','totalQuantity','lowStoc'));

    }

    public function approvalStore(Request $request, $id){
        foreach($request->selling_qty as $key => $val){
            $invoice_details = InvoiceDetail::where('id',$key)->first();
           $product = Product::where('id',$invoice_details->product_id)->first();
            if($product->quantity < $request->selling_qty[$key]){
                return redirect()->back()->with('error','Sorry! You Approved Maximum Value');
                }
            }

            $invoice = Invoice::find($id);
            $invoice->approved_by = Auth::user()->id;
            $invoice->status = '1';
            DB::transaction(function () use ($request,$invoice,$id) {
            foreach($request->selling_qty as $key => $val){
                $invoice_details = InvoiceDetail::where('id',$key)->first();
                $invoice_details->status = '1';
                $invoice_details->save();
                $product = Product::where('id',$invoice_details->product_id)->first();
                $product->quantity = ((float)$product->quantity)-((float)$request->selling_qty[$key]);
                $product->save();
            }
            $invoice->save();
        });
        return redirect()->route('invoice.pending.list')->with('success','Invoice Approved SuccessFully');
    }
    public function printInvoiceList(){
        $lowStoc = 5;
        $totalQuantity = Product::where('status',1)->sum('quantity');

        $allData = Invoice::orderBy('date','desc')->orderBy('id','desc')->where('status','1')->get();
        return view('backend.invoice.pos-invoice-list',compact('allData','totalQuantity','lowStoc'));
    }

    function printInvoice($id) {
        $data['invoice'] = Invoice::with('invoice_details')->find($id);
        $pdf = PDF::loadView('backend.pdf.invoice-pdf', $data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');
        return $pdf->stream('document.pdf');
    }
    public function dailyReport(){
        $lowStoc = 5;
        $totalQuantity = Product::where('status',1)->sum('quantity');

        return view('backend.invoice.daily-invoice-report',compact('totalQuantity','lowStoc'));
    }
    public function dailyReportPdf(Request $request){
        $sdate = date('Y-m-d',strtotime($request->start_date));
        $edate = date('Y-m-d',strtotime($request->end_date));
        $data['allData'] = Invoice::whereBetween('date',[$sdate,$edate])->where('status','1')->get();
        $data['start_date'] = date('Y-m-d',strtotime($request->start_date));
        $data['end_date'] = date('Y-m-d',strtotime($request->end_date));
        $pdf = PDF::loadView('backend.pdf.daily-invoice-report-pdf', $data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');
        return $pdf->stream('document.pdf');

    }



}
