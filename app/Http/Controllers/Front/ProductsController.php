<?php

namespace App\Http\Controllers\Front;

use App\Cart;
use App\ProductsAttribute;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Route;
use App\Category;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Session;


class ProductsController extends Controller
{
    public function listing(Request $request)
    {
        Paginator::useBootstrap();
        if ($request->ajax()) {
            $data = $request->all();
            $url = $data['url'];

            $categoryCount = Category::where(['url' => $url, 'status' => 1])->count();
            if ($categoryCount > 0) {
                $categoryDetails = Category::catDetails($url);
                $categoryProducts = Product::with('brand')
                    ->whereIn('category_id', $categoryDetails['catIds'])->where('status', 1);
                //If Fabric filter is selected
                if (isset($data['fabric']) && !empty($data['fabric'])) {
                    $categoryProducts->whereIn('products.fabric', $data['fabric']);
                }
                if (isset($data['sleeve']) && !empty($data['sleeve'])) {
                    $categoryProducts->whereIn('products.sleeve', $data['sleeve']);
                }
                if (isset($data['pattern']) && !empty($data['pattern'])) {
                    $categoryProducts->whereIn('products.pattern', $data['pattern']);
                }
                if (isset($data['fit']) && !empty($data['fit'])) {
                    $categoryProducts->whereIn('products.fit', $data['fit']);
                }
                if (isset($data['occasion']) && !empty($data['occasion'])) {
                    $categoryProducts->whereIn('products.occasion', $data['occasion']);
                }

                //if sort selected by user
                if (isset($data['sort']) && !empty($data['sort'])) {
                    if ($data['sort'] == "product_latest") {
                        $categoryProducts->orderBy('id', 'Desc');
                    } else if ($data['sort'] == "product_name_a_z") {
                        $categoryProducts->orderBy('product_name', 'Asc');
                    } else if ($data['sort'] == "product_name_z_a") {
                        $categoryProducts->orderBy('product_name', 'Desc');
                    } else if ($data['sort'] == "product_lowest") {
                        $categoryProducts->orderBy('product_price', 'Asc');
                    } else if ($data['sort'] == "product_highest") {
                        $categoryProducts->orderBy('product_price', 'Desc');
                    } else {
                        $categoryProducts->orderBy('id', 'Desc');
                    }
                }
                $categoryProducts = $categoryProducts->paginate(30);

                return view('front.products.ajax_products_listing')->with(compact('categoryDetails', 'categoryProducts', 'url'));

            } else {
                abort(404);
            }
        } else {
            $url = Route::getFacadeRoot()->current()->uri();
            $categoryCount = Category::where(['url' => $url, 'status' => 1])->count();
            if ($categoryCount > 0) {
                $categoryDetails = Category::catDetails($url);
                $categoryProducts = Product::with('brand')
                    ->whereIn('category_id', $categoryDetails['catIds'])->where('status', 1);

                $categoryProducts = $categoryProducts->paginate(30);
                $productFilters = Product::productsFilter();
                $fabricArray = $productFilters['fabricArray'];
                $sleeveArray = $productFilters['sleeveArray'];
                $patternArray = $productFilters['patternArray'];
                $fitArray = $productFilters['fitArray'];
                $occasionArray = $productFilters['occasionArray'];
                $page_name = "listing";
                return view('front.products.listing')->with(compact('categoryDetails', 'categoryProducts'
                    , 'url', 'fabricArray', 'sleeveArray', 'patternArray', 'fitArray', 'occasionArray', 'page_name'));

            } else {
                abort(404);
            }
        }

    }

    public function detail($id)
    {
        $productDetails = Product::with(['category', 'brand', 'attributes'=>function($query){
            $query->where('status',1);
        }, 'images'])->find($id)->toArray();

        $total_stock = ProductsAttribute::where('product_id', $id)->sum('stock');
        $relatedProducts=Product::where('category_id',$productDetails['category']['id'])->limit(3)->inRandomOrder()->where('id','!=',$id)->get()->toArray();
        return view('front.products.detail')->with(compact('productDetails', 'total_stock','relatedProducts'));
    }

    public function getProductPrice(Request $request){
        $data=$request->all();
        if (!empty($data['size'])){
            $getProductPrice=ProductsAttribute::where(['product_id'=>$data['id'],'size'=>$data['size']])->first();
            return $getProductPrice->price;
        }else{
            $getProductPrice=Product::where('id',$data['id'])->first();
            return $getProductPrice->product_price;
        }


    }

    public function addtocart(Request $request){
        if ($request->isMethod('post')){
            $data=$request->all();
            /*dd($data);*/
            //check product stock available or not
            $getProductStock=ProductsAttribute::where(['product_id'=>$data['product_id'],'size'=>$data['size']])->first()->toArray();
            if ($getProductStock['stock'] < $data['quantity']){
                $message="Required Quantity is not available !";
                session::flash('error-message',$message);
                return redirect()->back();

            }
            // Generate Session Id if nor exist
            $session_id=Session::get('session_id');
            if (empty($session_id)){
                $session_id=Session::getId();
                Session::put('session_id',$session_id);
            }
            //check product if already exist in cart
            $countProducts=Cart::where(['product_id'=>$data['product_id'],'size'=>$data['size']])->count();
            if ($countProducts>0){
                $message="product already exists !";
                session::flash('error-message',$message);
                return redirect()->back();
            }
            //Save Product in Cart

            $cart=new Cart;
            $cart->session_id=$session_id;
            $cart->product_id=$data['product_id'];
            $cart->size=$data['size'];
            $cart->quantity=$data['quantity'];
            $cart->save();

            $message="Product has been added in Cart";
            session::flash('success_message',$message);
            return redirect()->back();
        }


    }
}

