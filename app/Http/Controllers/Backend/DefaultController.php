<?php

namespace App\Http\Controllers\Backend;

use Auth;
use App\Model\Unit;
use App\Model\Product;
use App\Model\Category;
use App\Model\Purchase;
use App\Model\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DefaultController extends Controller
{
    public function getCategory(Request $requist) {
        $supplier_id = $requist->supplier_id;
        $allCategory = Product::with(['category'])->select('category_id')->where('supplier_id',$supplier_id)->groupBy('category_id')->get();

        return response()->json($allCategory);
    }

    public function getProduct(Request $requist) {
        $category_id = $requist->category_id;
        $allProduct = Product::where('category_id',$category_id)->get();

        return response()->json($allProduct);
    }

    public function getStock(Request $requist){
        $product_id = $requist->product_id;
        $stock = Product::where('id',$product_id)->first()->quantity;

        return response()->json($stock);
    }
}
