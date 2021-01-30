<?php

namespace App\Http\Controllers\Admin;

use App\Brand;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
class BrandContorller extends Controller
{
    public function brands()
    {
        Session::put('page','brands');
        $brands=Brand::all();
        return view('admin.brands.brands')->with(compact('brands'));
    }
    public function updateBrandsStatus(Request $request){
        if ($request->ajax()){
            if ($request->brandStatus=="Active"){
                $brandStatus=0;
            }else{
                $brandStatus=1;
            }
            Brand::where('id',$request->brandId)->update(['status'=>$brandStatus]);
            return response()->json(['brandStatus'=>$brandStatus,'brandId'=>$request->brandId]);
            /*   return $request->all();*/
        }
    }
    public function addEditBrand(Request $request,$id=null){
        Session::put('page','brands');
        if ($id==""){
            $title="Add Brand";
            $brand=new Brand;
            $message="brand added successfully";

        }else{
            $title="Edit Brand";
            $brand=Brand::find($id);
            $message="Brand Updated successfully";
        }
        if ($request->isMethod('post')){
            $data=$request->all();
            $rule = [
                'brand_name' => 'required|regex:/^[\pL\s\-]+$/u',
            ];
            $customMessage = [
                'brand_name.required' => 'Brand Name is require',
                'brand_name.regex' => 'Valid name is require',
            ];
            $this->validate($request,$rule,$customMessage);
            $brand->name=$data['brand_name'];
            $brand->save();
            Session::flash('flash_message_success',$message);
            return redirect('admin/brands');
        }
        return view('admin.brands.add_edit_brand')->with(compact('title','brand'));

    }
    public function deleteBrand($id){
        Brand::where('id',$id)->delete();
        $message='Brand has been deleted successfully';
        Session::flash('flash_message_success',$message);
        return redirect()->back();
    }
}
