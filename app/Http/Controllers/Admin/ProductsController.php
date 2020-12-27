<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Session;
class ProductsController extends Controller
{
    public function products()
    {
        Session::put('page','products');
        $products = Product::with(['category'=>function($query){
            $query->select('id','category_name');
        },'section'=>function($query){
            $query->select('id','name');
        }])->get();
        $products = json_decode(json_encode($products));
        return view('admin.products.products')->with(compact('products'));

    }

    public function updateProductStatus(Request $request)
    {
        if ($request->ajax()) {
            if ($request->proStatus == "Active") {
                $proStatus = 0;
            } else {
                $proStatus = 1;
            }
            Product::where('id', $request->proId)->update(['status' => $proStatus]);
            return response()->json(['proStatus' => $proStatus, 'product_id' => $request->proId]);
            /*   return $request->all();*/
        }

    }

    public function deleteProduct($id)
    {
        Product::where('id',$id)->delete();
        return redirect()->back()->with('flash_message_success','Product  has been deleted successfully');
    }
}
