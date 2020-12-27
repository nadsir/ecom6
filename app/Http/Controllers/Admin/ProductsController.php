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

    public function addEditProduct(Request $request,$id=null)
    {
        if ($id=='')
        {
            $title='Add Products';
        }else{
            $title='Edit Products';
        }
        //Filter Arrays
        $fabricArray=array('Cotton','Polyester','wool');
        $sleeveArray=array('Full Sleeve','Half Sleeve','Short Sleeve','slleveless');
        $patternArray=array('Checked','Plain','Printed','Self','Solid');
        $fitArray=array('Regular','slim','wool');
        $occassionArray=array('Casual','Formal');



        return view('admin.products.add_edit_products')->with(compact('title','fabricArray','sleeveArray','patternArray','fitArray','occassionArray'));
    }
}
