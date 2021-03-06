<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/
use  App\Category;
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('/admin')->namespace('Admin')->group(function (){
    Route::match(['get','post'],'/','AdminController@login');

    Route::group(['middleware'=>['admin']],function (){
        Route::get('dashboard','AdminController@dashboard');
        Route::get('setting','AdminController@setting');
        Route::get('logout','AdminController@logout');
        Route::post('check-current-pwd','AdminController@chkCurrentPassword');
        Route::post('update-current-pwd','AdminController@updateCurrentPassword');
        Route::match(['get','post'],'update-admin-details','AdminController@updateAdminDetails');
        //section
        Route::get('sections','SectionController@sections');
        Route::post('update-section-status','SectionController@updateSectionStatus');
        //Category
        Route::get('categories','CategoryController@categories');
        Route::post('update-category-status','CategoryController@updateCategoryStatus');
        Route::match(['get','post'],'add-edit-category/{id?}','CategoryController@addEditCategory');
        //
        Route::post('append-categories-level','CategoryController@appenCategoryLevel');
        Route::get('delete-category-image/{id}','CategoryController@deleteCategoryImage');
        Route::get('delete-category/{id}','CategoryController@deleteCategory');
        //products
        Route::get('products','ProductsController@products');
        Route::post('update-product-status','ProductsController@updateProductStatus');
        Route::get('delete-product/{id}','ProductsController@deleteProduct');
        Route::match(['get','post'],'add-edit-product/{id?}','ProductsController@addEditProduct');
        Route::get('delete-product-image/{id}','ProductsController@deleteProductImage');
        Route::get('delete-product-video/{id}','ProductsController@deleteProductVideo');
        Route::match(['get','post'],'add-attributes/{id}','ProductsController@addAttributes');
        Route::post('edit-attributes/{id}','ProductsController@editAttributes');

        Route::post('update-attribute-status','ProductsController@updateAttributeStatus');
        Route::get('delete-attribute/{id}','ProductsController@deleteProductAttribute');

        //Images
        Route::match(['get','post'],'add-images/{id}','ProductsController@addImages');
        Route::post('update-image-status','ProductsController@updateImageStatus');
        Route::get('delete-image/{id}','ProductsController@deleteProductImages');
        //Brands
        Route::get('brands','BrandContorller@brands');
        Route::post('update-brands-status','BrandContorller@updateBrandsStatus');
        Route::match(['get','post'],'add-edit-brand/{id?}','BrandContorller@addEditBrand');
        Route::get('delete-brand/{id}','BrandContorller@deleteBrand');

        Route::get('banners','BannersController@banners');
        Route::match(['get','post'],'add-edit-banner/{id?}','BannersController@addeditBanner');
        Route::post('update-banners-status','BannersController@updateBannersStatus');
        Route::get('delete-banner/{id}','BannersController@deleteBanner');

    });

});

Route::get('/test','TestController@showMenu');

Route::namespace('Front')->group(function (){
//    Homepage Route
    Route::get('/','IndexController@index');
// listing Route
    /*Route::match(['get','post'],'/{url}','ProductsController@listing');*/
    $catUrls=Category::select('url')->where('status',1)->get()->pluck('url')->toArray();
    foreach ($catUrls as $url){
        Route::match(['get','post'],'/'.$url,'ProductsController@listing');
    }
    //Product detail route
    Route::get('/product/{id}','ProductsController@detail');
    Route::post('get-product-price','ProductsController@getProductPrice');
    //Add to Cart Route
    Route::post('/add-to-cart','ProductsController@addtocart');
    Route::get('/cart','ProductsController@cart');
});
