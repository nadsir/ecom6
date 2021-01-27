<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Product;
use App\ProductsAttribute;
use App\ProductsImage;
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
            $productdata=array();
            $message="Product added successfully";
        }else{
            $title='Edit Products';
            $productdata=Product::find($id);
            $productdata=json_decode(json_encode($productdata),true);
            $product=Product::find($id);
            $message="Product update successfully";

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
                }else{

                }
            }
            //upload product video
            if ($request->hasFile('product_video')){
                $video_temp=$request->file('product_video');
                if ($video_temp->isValid()){
                    $video_name=pathinfo($video_temp->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension=$video_temp->getClientOriginalExtension();
                    $videoName=$video_name.'-'.rand(111,99999).'.'.$extension;
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

            $product->product_weight=$data['product_weight'];



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
            if (!empty($data['is_featured'])) {
                $product->is_featured = $data['is_featured'];
            }
            $product->is_featured = 'No';
            $product->save();
            session::flash('success_message',$message);
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




        return view('admin.products.add_edit_products')->with(compact('title','fabricArray','sleeveArray','patternArray','fitArray','occasionArray','categories','productdata'));
    }
    public function deleteProductImage($id){
        //get product image
        $productImage=Product::select('main_image')->where('id',$id)->first();
        //get category image paths
        $small_image_path='images/admin_images/product_images/small/';
        $medium_image_path='images/admin_images/product_images/medium/';
        $large_image_path='images/admin_images/product_images/large/';
        //delete small product image from product_images folder if exist
        if (file_exists($small_image_path.$productImage->main_image)){
            unlink($small_image_path.$productImage->main_image);
        }
        if (file_exists($medium_image_path.$productImage->main_image)){
            unlink($medium_image_path .$productImage->main_image);
        }
        if (file_exists($large_image_path.$productImage->main_image)){
            unlink($large_image_path .$productImage->main_image);
        }
        //delete category image form categories table
        Product::where('id',$id)->update(['main_image'=>'']);
        return redirect()->back()->with('flash_message_success','Product image has been deleted successfully');
    }
    public function deleteProductVideo($id){
        //get category image
        $productImage=Product::select('product_video')->where('id',$id)->first();
        //get category image path
        $productVideo_image_path='videos/product_videos/';
        //delete category image from category_images folder if exist
        if (file_exists($productVideo_image_path.$productImage->product_video)){
            unlink($productVideo_image_path.$productImage->product_video);
        }
        //delete category image form categories table
         Product::where('id',$id)->update(['product_video'=>'']);
        return redirect()->back()->with('flash_message_success','Product video has been deleted successfully');
    }

    public function addAttributes(Request $request,$id)
    {
        if ($request->isMethod('post')){
            $data=$request->all();
            foreach ($data['sku'] as $key => $value){
                if (!empty($value)){
                    //SKU already exists check

                    $attrContSKU=ProductsAttribute::where(['product_id'=>$id,'sku'=>$data['sku'][$key]])->count();
                    if($attrContSKU>0){
                        $message='SKU already exists.please add another SKU';
                            session::flash('error-message',$message);
                            return redirect()->back();
                    }
                    $attrContSize=ProductsAttribute::where(['product_id'=>$id,'size'=>$data['size'][$key]])->count();
                    if($attrContSize>0){
                        $message='size already exists.please add another Size';
                        session::flash('error-message',$message);
                        return redirect()->back();
                    }
                    $attribute=new ProductsAttribute;
                    $attribute->product_id=$id;
                    $attribute->sku=$value;
                    $attribute->size=$data['size'][$key];
                    $attribute->price=$data['price'][$key];
                    $attribute->stock=$data['stock'][$key];
                    $attribute->status=1;
                    $attribute->save();
                }
            }
            $success_message='Product Attributes has added successfully';
            session::flash('flash_message_success',$success_message);
            return redirect()->back();

        }

        $productdata=Product::select('id','product_name','product_code','product_color','main_image')->with('attributes')->find($id);
        $productdata=json_decode(json_encode($productdata));
        $title="Product Attributes";
        return view('admin.products.add_attributes')->with(compact('productdata','title'));

    }

    public function editAttributes(Request $request,$id)
    {
        if ($request->isMethod('post')){
            $data=$request->all();

            foreach ($data['attrId'] as $key=>$attr){}
            if (!empty($attr)){}
            ProductsAttribute::where(['id'=>$data['attrId'][$key]])->update(['price'=>$data['price'][$key],'stock'=>$data['stock'][$key]]);
            $message='Product attributes has been updated successfully';
            session::flash('flash_message_success',$message);
            return redirect()->back();
        }
    }

    public function updateAttributeStatus(Request $request){

        if ($request->ajax()) {
            if ($request->attrStatus == "Active") {
                $attrStatus = 0;
            } else {
                $attrStatus = 1;
            }

            ProductsAttribute::where('id', $request->attrId)->update(['status' => $attrStatus]);
            return response()->json(['attrStatus' => $attrStatus, 'product_id' => $request->attrId]);
            /*   return $request->all();*/
        }
    }

    public function deleteProductAttribute($id)
    {
        ProductsAttribute::where('id',$id)->delete();
        return redirect()->back()->with('flash_message_success','Product  has been deleted successfully');
    }

    public function addImages(Request $request,$id)
    {
        if($request->isMethod('post')){

            if($request->hasFile('images')){
                $images=$request->file('images');
                foreach ($images as $key=>$image){
                    $prdouctImage=new ProductsImage;
                    $image_tmp=Image::make($image);
                    $extension=$image->getClientOriginalExtension();
                    $imageName=rand(111,999999).time().".".$extension;
                    $large_image_path='images/admin_images/product_images/large/'.$imageName;
                    $medium_image_path='images/admin_images/product_images/medium/'.$imageName;
                    $small_image_path='images/admin_images/product_images/small/'.$imageName;
                    Image::make($image_tmp)->save($large_image_path);
                    Image::make($image_tmp)->resize(520,600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(260,300)->save($small_image_path);

                    $prdouctImage->image=$imageName;
                    $prdouctImage->product_id=$id;
                    $prdouctImage->save();

                }
                $message='Product Images has been added successfully';
                session::flash('flash_message_success',$message);
                return redirect()->back();
            }
        }
        $productdata=Product::with('images')->select('id','product_name','product_code','product_color','main_image')->first($id);
        $title="Product Images";
        return view('admin.products.add_images')->with(compact('productdata','title'));

    }

    public function updateImageStatus(Request $request){

        if ($request->ajax()) {
            if ($request->imgStatus == "Active") {
                $imgStatus = 0;
            } else {
                $imgStatus = 1;
            }

            ProductsImage::where('id', $request->imgId)->update(['status' => $imgStatus]);
            return response()->json(['attrStatus' => $imgStatus, 'image_id' => $request->imgId]);
            /*   return $request->all();*/
        }
    }
    public function deleteProductImages($id)
    {
        $productImage=ProductsImage::select('image')->where('id',$id)->first();
        //get category image paths
        $small_image_path='images/admin_images/product_images/small/';
        $medium_image_path='images/admin_images/product_images/medium/';
        $large_image_path='images/admin_images/product_images/large/';
        //delete small product image from product_images folder if exist
        if (file_exists($small_image_path.$productImage->image)){
            unlink($small_image_path.$productImage->image);
        }
        if (file_exists($medium_image_path.$productImage->image)){
            unlink($medium_image_path .$productImage->image);
        }
        if (file_exists($large_image_path.$productImage->image)){
            unlink($large_image_path .$productImage->image);
        }
        ProductsImage::where('id',$id)->delete();
        return redirect()->back()->with('flash_message_success','Product Image  has been deleted successfully');
    }
}
