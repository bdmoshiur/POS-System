<?php

namespace App\Http\Controllers\Backend;

use PDF;
use Auth;
use App\Model\Unit;
use App\Model\Product;
use App\Model\Category;
use App\Model\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class StockController extends Controller
{
    public function stockReport() {
        $totalQuantity = Product::where('status',1)->sum('quantity');
        $allData = Product::orderBy('supplier_id','asc')->orderBy('category_id','asc')->get();

        return view('backend.stock.stock-report',compact('allData','totalQuantity'));
    }
    
    public function stockReportPdf() {
        $data['allData'] = Product::orderBy('supplier_id','asc')->orderBy('category_id','asc')->get();
        $pdf = PDF::loadView('backend.pdf.stock-report-pdf', $data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');

        return $pdf->stream('document.pdf');
    }

    public function supplierProductWise() {
        $data['totalQuantity'] = Product::where('status',1)->sum('quantity');
        $data['suppliers'] = Supplier::all();
        $data['categories'] = Category::all();

        return view('backend.stock.supplier-product-wise-report',$data);
    }

    public function supplierWisePdf(Request $request) {
        $data['allData'] = Product::orderBy('supplier_id','asc')->orderBy('category_id','asc')->where('supplier_id',$request->supplier_id)->get();
        $pdf = PDF::loadView('backend.pdf.supplier-wise-stock-report-pdf', $data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');

        return $pdf->stream('document.pdf');
    }

    public function productWisePdf(Request $request) {
        $data['product'] = Product::where('category_id',$request->category_id)->where('id',$request->product_id)->first();
        $pdf = PDF::loadView('backend.pdf.product-wise-stock-report-pdf', $data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');

        return $pdf->stream('document.pdf');
    }
}
