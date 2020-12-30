<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Product;
use App\Section;
use Image;
use Illuminate\Http\Request;
use Session;
use function PHPUnit\Framework\isEmpty;

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
            $title='Add Product';
            $product=new Product;
        }else{
            $title='Edit Products';
        }
        if ($request->isMethod('post')){
            $data=$request->all();
            //product Validation
            $role = [
                'category_id'=>'required',
                'product_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'product_code' => 'required|regex:/^[\w-]*$/',
                'product_price'=>'required|numeric',
                'product_color'=>'required|regex:/^[\pL\s\-]+$/u',

            ];
            $customMessage = [
                'category_id.required' => 'Name is require',
                'product_name.required' => 'Product Name is require',
                'product_name.regex' => 'Valid Product name is require',
                'product_code.required' => 'Product code is require',
                'product_code.regex' => 'Valid Product code is require',
                'product_price.required' => 'Product Price is require',
                'product_price.numeric' => 'Valid Product Price is require',
                'product_color.required' => 'Product Color is require',
                'product_color.regex' => 'Valid Product Color is require',

            ];
            $this->validate($request, $role, $customMessage);
            if (empty($data['is_featured'])){
                $is_featured="No";
            }else{
                $is_featured="Yes";
            }
            if (empty($data['fabric'])){
                $data['fabric']="";
            }
            if (empty($data['product_video'])){
                $data['product_video']="";
            }
            if (empty($data['main_image'])){
                $data['main_image']="";
            }
            if (empty($data['product_discount'])){
                $data['product_discount']=10.3;
            }
            if (empty($data['product_weight'])){
                $data['product_weight']=10.3;
            }

            if (empty($data['pattern'])){
                $data['pattern']="";
            }
            if (empty($data['sleeve'])){
                $data['sleeve']="";
            }
            if (empty($data['fit'])){
                $data['fir']="";
            }
            if (empty($data['occasion'])){
                $data['occasion']="";
            }
            if (empty($data['description'])){
                $data['description']="";
            }
            if (empty($data['wash_care'])){
                $data['wash_care']="";
            }
            if (empty($data['meta_title'])){
                $data['meta_title']="";
            }
            if (empty($data['meta_description'])){
                $data['meta_description']="";
            }
            if (empty($data['meta_keywords'])){
                $data['meta_keywords']="";
            }
            //Upload Product Images
            if ($request->hasFile('main_image')){
                $image_tmp=$request->file('main_image');
                if ($image_tmp->isValid()){
                    //upload Image after Resize

                    $image_name=pathinfo($image_tmp->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension=$image_tmp->getClientOriginalExtension();

                    $imageName=$image_name.'-'.rand(111,99999).'.'.$extension;

                    $large_image_path='images/admin_images/product_images/large/'.$imageName;
                    $medium_image_path='images/admin_images/product_images/medium/'.$imageName;
                    $small_image_path='images/admin_images/product_images/small/'.$imageName;
                    Image::make($image_tmp)->save($large_image_path);
                    Image::make($image_tmp)->resize(520,600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(260,300)->save($small_image_path);

                    $product->main_image=$imageName;
                }
            }
            //upload product video
            if ($request->hasFile('product_video')){
                $video_temp=$request->file('product_video');
                if ($video_temp->isValid()){
                    $video_name=pathinfo($video_temp->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension=$video_temp->getClientOriginalExtension();
                    $videoName=$video_name.'-'.rand().'.'.$extension;
                    $video_path='videos/product_videos/';
                    $video_temp->move($video_path,$videoName);
                    //save video in products table
                    $product->product_video=$videoName;

                }
            }




            //save Product details in product table
            $categoryDetails=Category::find($data['category_id']);
            $product->section_id=$categoryDetails['section_id'];
            $product->category_id=$data['category_id'];
            $product->product_name=$data['product_name'];
            $product->product_code=$data['product_code'];
            $product->product_color=$data['product_color'];
            $product->product_price=$data['product_price'];
            $product->product_discount=$data['product_discount'];
            $product->product_video=$data['product_video'];
            $product->product_weight=$data['product_weight'];
            if (!isset($imageName)){
                $product->main_image=$data['main_image'];
            }

            $product->description=$data['description'];
            $product->wash_care=$data['wash_care'];
            $product->fabric=$data['fabric'];
            $product->pattern=$data['sleeve'];
            $product->sleeve=$data['category_id'];
            $product->fit=$data['fit'];
            $product->occasion=$data['occasion'];
            $product->meta_title=$data['meta_title'];
            $product->meta_keywords=$data['meta_keywords'];
            $product->meta_description=$data['meta_description'];
            $product->status=1;
            $product->is_featured=$is_featured;
            $product->save();
            session::flash('success_message','Product added successfully!');
            return redirect('admin/products');
        }


        //Filter Arrays
        $fabricArray=array('Cotton','Polyester','wool');
        $sleeveArray=array('Full Sleeve','Half Sleeve','Short Sleeve','sleeveless');
        $patternArray=array('Checked','Plain','Printed','Self','Solid');
        $fitArray=array('Regular','slim','wool');
        $occasionArray=array('Casual','Formal');
        //Sections with categories and sub categories
        $categories=Section::with('categories')->get();
        $categories=json_decode(json_encode($categories),true);




        return view('admin.products.add_edit_products')->with(compact('title','fabricArray','sleeveArray','patternArray','fitArray','occasionArray','categories'));
    }
}
