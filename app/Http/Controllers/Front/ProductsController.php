<?php

namespace App\Http\Controllers\Front;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Route;
use App\Category;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function listing(Request $request)
    {
        Paginator::useBootstrap();
        if ($request->ajax()){
            $data=$request->all();
            $url=$data['url'];

            $categoryCount = Category::where(['url' => $url, 'status' => 1])->count();
            if ($categoryCount > 0) {
                $categoryDetails = Category::catDetails($url);
                $categoryProducts = Product::with('brand')
                    ->whereIn('category_id', $categoryDetails['catIds'])->where('status', 1);
                //If Fabric filter is selected
                if (isset($data['fabric']) && !empty($data['fabric'])) {
                    $categoryProducts->whereIn('products.fabric',$data['fabric']);
                }
                if (isset($data['sleeve']) && !empty($data['sleeve'])) {
                    $categoryProducts->whereIn('products.sleeve',$data['sleeve']);
                }
                if (isset($data['pattern']) && !empty($data['pattern'])) {
                    $categoryProducts->whereIn('products.pattern',$data['pattern']);
                }
                if (isset($data['fit']) && !empty($data['fit'])) {
                    $categoryProducts->whereIn('products.fit',$data['fit']);
                }
                if (isset($data['occasion']) && !empty($data['occasion'])) {
                    $categoryProducts->whereIn('products.occasion',$data['occasion']);
                }

                //if sort selected by user
                if (isset($data['sort']) && !empty($data['sort'])) {
                    if ($data['sort'] == "product_latest") {
                        $categoryProducts->orderBy('id', 'Desc');
                    } else if ($data['sort'] == "product_name_a_z") {
                        $categoryProducts->orderBy('product_name', 'Asc');
                    }
                    else if ($data['sort'] == "product_name_z_a") {
                        $categoryProducts->orderBy('product_name', 'Desc');
                    }
                    else if ($data['sort'] == "product_lowest") {
                        $categoryProducts->orderBy('product_price', 'Asc');
                    }
                    else if ($data['sort'] == "product_highest") {
                        $categoryProducts->orderBy('product_price', 'Desc');
                    }
                    else {
                        $categoryProducts->orderBy('id', 'Desc');
                    }
                }
                $categoryProducts = $categoryProducts->paginate(3);

                return view('front.products.ajax_products_listing')->with(compact('categoryDetails', 'categoryProducts','url'));

            } else {
                abort(404);
            }
        }
        else{
            $url=Route::getFacadeRoot()->current()->uri();
            $categoryCount = Category::where(['url' => $url, 'status' => 1])->count();
            if ($categoryCount > 0) {
                $categoryDetails = Category::catDetails($url);
                $categoryProducts = Product::with('brand')
                    ->whereIn('category_id', $categoryDetails['catIds'])->where('status', 1);

                $categoryProducts = $categoryProducts->paginate(3);
                $productFilters=Product::productsFilter();
                $fabricArray=$productFilters['fabricArray'];
                $sleeveArray=$productFilters['sleeveArray'];
                $patternArray=$productFilters['patternArray'];
                $fitArray=$productFilters['fitArray'];
                $occasionArray=$productFilters['occasionArray'];
                $page_name="listing";
                return view('front.products.listing')->with(compact('categoryDetails', 'categoryProducts'
                    ,'url','fabricArray','sleeveArray','patternArray','fitArray','occasionArray','page_name'));

            } else {
                abort(404);
            }
        }

        }
    }

